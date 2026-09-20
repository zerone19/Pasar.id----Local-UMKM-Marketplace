import { Injectable, ForbiddenException, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';
import { normalizeProductImages } from '../../common/product-images';
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

    if (productIds.length === 0) {
      return {
        totalProducts: 0,
        totalStock: 0,
        totalOrders: 0,
        totalRevenue: 0,
        totalSold: 0,
        lowStock: 0,
      };
    }

    // Fetch completed order items to calculate real revenue and units sold
    const completedItems = await this.prisma.orderItem.findMany({
      where: {
        productId: { in: productIds },
        order: { status: 'COMPLETED' },
      },
      select: {
        price: true,
        quantity: true,
      },
    });

    const totalRevenue = completedItems.reduce(
      (sum, item) => sum + Number(item.price) * item.quantity,
      0,
    );

    const totalSold = completedItems.reduce(
      (sum, item) => sum + item.quantity,
      0,
    );

    // Total distinct orders that contain this seller's products
    const sellerOrderItems = await this.prisma.orderItem.findMany({
      where: { productId: { in: productIds } },
      select: { orderId: true },
      distinct: ['orderId'],
    });

    return {
      totalProducts: products.length,
      totalStock: products.reduce((sum, p) => sum + p.stock, 0),
      totalOrders: sellerOrderItems.length,
      totalRevenue,
      totalSold,
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
    const category = await this.prisma.category.findUnique({ where: { id: data.categoryId }, select: { slug: true } });
    const images = normalizeProductImages(data.images, category?.slug);
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
        images,
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
    const product = await this.prisma.product.findFirst({
      where: { id: productId, sellerId: userId },
    });
    if (!product) throw new NotFoundException('Produk tidak ditemukan.');
    return await this.prisma.product.update({
      where: { id: productId },
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

  async updateOrderStatus(userId: string, orderId: string, status: string) {
    // Verify that this order contains products belonging to this seller
    const orderItem = await this.prisma.orderItem.findFirst({
      where: {
        orderId,
        product: { sellerId: userId },
      },
    });
    if (!orderItem) {
      throw new ForbiddenException('Pesanan tidak ditemukan atau tidak memuat produk dari toko Anda.');
    }

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