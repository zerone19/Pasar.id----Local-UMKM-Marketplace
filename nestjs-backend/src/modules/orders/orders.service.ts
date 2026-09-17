import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';
import { OrderStatus } from '@prisma/client';

@Injectable()
export class OrdersService {
  constructor(private readonly prisma: PrismaService) {}

  async findAll() {
    return this.prisma.order.findMany({
      include: { user: true, items: { include: { product: true } } },
    });
  }

  async findById(id: string) {
    const order = await this.prisma.order.findUnique({
      where: { id },
      include: { user: true, items: { include: { product: true } } },
    });
    if (!order) throw new NotFoundException('Order tidak ditemukan');
    return order;
  }

  async create(dto: { userId: string; items: { productId: string; quantity: number }[]; shippingAddress: string; paymentMethod?: string }) {
    const totalAmount = await this.calculateTotal(dto.items);
    const orderNumber = `ORD-${Date.now()}-${Math.random().toString(36).substr(2, 4).toUpperCase()}`;

    return this.prisma.$transaction(async (tx) => {
      // First create the order without items
      const order = await tx.order.create({
        data: {
          orderNumber,
          status: OrderStatus.PENDING,
          totalAmount,
          paymentMethod: dto.paymentMethod ?? 'COD',
          paymentStatus: 'PENDING',
          userId: dto.userId,
          shippingAddress: dto.shippingAddress,
        },
      });

      // Then create order items with correct prices
      for (const item of dto.items) {
        const product = await tx.product.findUnique({ where: { id: item.productId } });
        await tx.orderItem.create({
          data: {
            orderId: order.id,
            quantity: item.quantity,
            price: product ? Number(product.price) : 0,
            productId: item.productId,
          },
        });
      }

      // Update stock
      for (const item of dto.items) {
        await tx.product.update({
          where: { id: item.productId },
          data: { stock: { decrement: item.quantity } },
        });
      }

      // Return order with items
      return tx.order.findUnique({
        where: { id: order.id },
        include: { user: true, items: { include: { product: true } } },
      });
    });
  }

  private async calculateTotal(items: { productId: string; quantity: number }[]) {
    let total = 0;
    for (const item of items) {
      const product = await this.prisma.product.findUnique({ where: { id: item.productId } });
      if (product) total += Number(product.price) * item.quantity;
    }
    return total;
  }
}
