import { Injectable } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';
import { OrderStatus } from '@prisma/client';

@Injectable()
export class SellerService {
  constructor(private readonly prisma: PrismaService) {}

  // ── Dashboard Stats ──
  async getDashboardStats(userId: string) {
    const products = await this.prisma.product.findMany({
      where: { sellerId: userId },
      select: { id: true, price: true, stock: true },
    });

    const productIds = products.map((p) => p.id);

    const orderItems = await this.prisma.orderItem.findMany({
      where: { productId: { in: productIds } },
      select: {
        price: true,
        orderId: true,
        product: { select: { id: true } },
      },
    });

    const completedOrderItems = orderItems.filter(async (item) => {
      const order = await this.prisma.order.findUnique({
        where: { id: item.orderId },
        select: { status: true },
      });
      return order?.status === 'COMPLETED';
    });

    // Simpler: fetch orders with their items directly
    const orders = await this.prisma.orderItem.groupBy({
      by: ['productId'],
      where: {
        productId: { in: productIds },
      },
      _sum: { quantity: true },
    });

    const totalQuantitySold = orders.reduce(
      (sum, item) => sum + (Number(item._sum.quantity) || 0),
      0,
    );

    const totalCompletedItems = await this.prisma.orderItem.count({
      where: {
        productId: { in: productIds },
        order: { status: 'COMPLETED' },
      },
    });

    const revenueAgg = await this.prisma.orderItem.aggregate({
      where: {
        productId: { in: productIds },
        order: { status: 'COMPLETED' },
      },
      _sum: { price: true },
    });

    return {
      totalProducts: products.length,
      totalStock: products.reduce(
        (sum, p) => sum + p.stock,
        0,
      ),
      totalOrders: await this.prisma.orderItem.count({
        where: {
          productId: { in: productIds },
        },
      }),
      totalRevenue: Number(revenueAgg._sum.price || 0),
      totalSold: totalCompletedItems,
      lowStock: products.filter((p) => p.stock <= 5).length,
    };
  }

  // ── Products ──
  async getSellerProducts(userId: string) {
    return await this.prisma.product.findMany({
      where: { sellerId: userId },
      include: {
        category: true,
        store: true,
      },
      orderBy: { createdAt: 'desc' },
    });
  }

  async getSellerProduct(userId: string, productId: string) {
    return await this.prisma.product.findFirst({
      where: { id: productId, sellerId: userId },
      include: { category: true, store: true },
    });
  }

  async createProduct(
    userId: string,
    data: {
      name: string;
      description?: string;
      price: number;
      stock: number;
      images: string[];
      categoryId: string;
      storeId?: string;
    },
  ) {
    return await this.prisma.product.create({
      data: {
        name: data.name,
        slug:
          data.name
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/^-+|-+$/g, '') +
          '-' + Date.now(),
        description: data.description,
        price: data.price,
        stock: data.stock,
        images: data.images,
        category: { connect: { id: data.categoryId } },
        seller: { connect: { id: userId } },
        store: data.storeId
          ? { connect: { id: data.storeId } }
          : undefined,
      },
    });
  }

  async updateProduct(
    userId: string,
    productId: string,
    data: any,
  ) {
    return await this.prisma.product.update({
      where: { id: productId, sellerId: userId },
      data,
    });
  }

  async deleteProduct(userId: string, productId: string) {
    return await this.prisma.product.delete({
      where: { id: productId, sellerId: userId },
    });
  }

  // ── Orders ──
  async getSellerOrders(userId: string) {
    const products = await this.prisma.product.findMany({
      where: { sellerId: userId },
      select: { id: true },
    });
    const productIds = products.map((p) => p.id);

    return await this.prisma.orderItem.findMany({
      where: { productId: { in: productIds } },
      include: {
        order: { include: { user: true } },
        product: true,
      },
      orderBy: { order: { createdAt: 'desc' } },
    });
  }

  async getOrderById(userId: string, orderItemId: string) {
    const orderItem = await this.prisma.orderItem.findUnique({
      where: { id: orderItemId },
      include: {
        order: { include: { user: true } },
        product: true,
      },
    });

    if (!orderItem) return null;

    // Verify ownership
    const product = await this.prisma.product.findUnique({
      where: { id: orderItem.productId },
      select: { sellerId: true },
    });

    if (product?.sellerId !== userId) return null;
    return orderItem;
  }

  async updateOrderStatus(orderId: string, status: string) {
    return await this.prisma.order.update({
      where: { id: orderId },
      data: {
        status: status as OrderStatus,
      },
    });
  }

  // ── Store Management ──
  async getSellerStore(userId: string) {
    return await this.prisma.store.findFirst({
      where: { ownerId: userId },
      include: { products: true },
    });
  }

  async createStore(
    userId: string,
    data: {
      name: string;
      description?: string;
      slug: string;
    },
  ) {
    return await this.prisma.store.create({
      data: {
        name: data.name,
        description: data.description,
        slug: data.slug,
        ownerId: userId,
      },
    });
  }

  async updateStore(
    userId: string,
    storeId: string,
    data: any,
  ) {
    return await this.prisma.store.update({
      where: { id: storeId, ownerId: userId },
      data,
    });
  }
}