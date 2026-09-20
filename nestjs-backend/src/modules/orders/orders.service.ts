import { Injectable, NotFoundException, BadRequestException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';
import { OrderStatus } from '@prisma/client';

@Injectable()
export class OrdersService {
  constructor(private readonly prisma: PrismaService) {}

  private readonly userSelect = {
    id: true,
    fullName: true,
    email: true,
    phone: true,
    address: true,
  };

  async findAll() {
    return this.prisma.order.findMany({
      include: {
        user: { select: this.userSelect },
        items: { include: { product: true } },
      },
      orderBy: { createdAt: 'desc' },
    });
  }

  async findByUser(userId: string) {
    return this.prisma.order.findMany({
      where: { userId },
      include: {
        user: { select: this.userSelect },
        items: { include: { product: true } },
      },
      orderBy: { createdAt: 'desc' },
    });
  }

  async findById(id: string) {
    const order = await this.prisma.order.findUnique({
      where: { id },
      include: {
        user: { select: this.userSelect },
        items: { include: { product: true } },
      },
    });
    if (!order) throw new NotFoundException('Order tidak ditemukan');
    return order;
  }

  async updateStatus(id: string, status: OrderStatus, paymentStatus?: string, notes?: string) {
    const order = await this.prisma.order.findUnique({ where: { id } });
    if (!order) throw new NotFoundException('Order tidak ditemukan');

    return this.prisma.order.update({
      where: { id },
      data: {
        status,
        paymentStatus: paymentStatus ?? order.paymentStatus,
      },
      include: {
        user: { select: this.userSelect },
        items: { include: { product: true } },
      },
    });
  }

  async create(dto: { userId: string; items: { productId: string; quantity: number }[]; shippingAddress: string; paymentMethod?: string }) {
    if (!dto.items || dto.items.length === 0) {
      throw new BadRequestException('Pesanan harus memiliki minimal 1 produk.');
    }

    // Validate user exists
    const user = await this.prisma.user.findUnique({ where: { id: dto.userId } });
    if (!user) {
      throw new NotFoundException('User tidak ditemukan.');
    }

    // Validate each product and check stock
    const productMap = new Map<string, any>();
    for (const item of dto.items) {
      if (!Number.isInteger(item.quantity) || item.quantity < 1) {
        throw new BadRequestException('Jumlah produk harus berupa bilangan bulat positif.');
      }
      const product = await this.prisma.product.findUnique({ where: { id: item.productId } });
      if (!product) {
        throw new NotFoundException(`Produk dengan ID ${item.productId} tidak ditemukan.`);
      }
      if (!product.isActive) {
        throw new BadRequestException(`Produk "${product.name}" sedang tidak aktif.`);
      }
      if (product.stock < item.quantity) {
        throw new BadRequestException(
          `Stok produk "${product.name}" tidak mencukupi (tersedia: ${product.stock}, diminta: ${item.quantity}).`,
        );
      }
      productMap.set(item.productId, product);
    }

    let totalAmount = 0;
    for (const item of dto.items) {
      const product = productMap.get(item.productId);
      totalAmount += Number(product.price) * item.quantity;
    }

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
        const product = productMap.get(item.productId);
        await tx.orderItem.create({
          data: {
            orderId: order.id,
            quantity: item.quantity,
            price: Number(product.price),
            productId: item.productId,
          },
        });
      }

      // Decrement stock
      for (const item of dto.items) {
        await tx.product.update({
          where: { id: item.productId },
          data: { stock: { decrement: item.quantity } },
        });
      }

      await tx.notification.create({
        data: {
          userId: dto.userId,
          title: 'Pesanan berhasil dibuat',
          message: `Pesanan ${orderNumber} sedang menunggu diproses.`,
          type: 'ORDER_CREATED',
        },
      });

      // Return order with items and user
      return tx.order.findUnique({
        where: { id: order.id },
        include: {
          user: { select: this.userSelect },
          items: { include: { product: true } },
        },
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
