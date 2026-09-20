import { BadRequestException, ForbiddenException, Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

@Injectable()
export class GrowthService {
  constructor(private readonly prisma: PrismaService) {}

  async listNotifications(userId: string) {
    return this.prisma.notification.findMany({ where: { userId }, orderBy: { createdAt: 'desc' }, take: 50 });
  }

  async markNotificationRead(userId: string, id: string) {
    const notification = await this.prisma.notification.findFirst({ where: { id, userId } });
    if (!notification) throw new NotFoundException('Notifikasi tidak ditemukan.');
    return this.prisma.notification.update({ where: { id }, data: { readAt: new Date() } });
  }

  async listReviews(productId: string) {
    return this.prisma.review.findMany({
      where: { productId },
      include: { user: { select: { id: true, fullName: true } } },
      orderBy: { createdAt: 'desc' },
    });
  }

  async createReview(userId: string, productId: string, rating: number, comment?: string, orderId?: string) {
    if (!orderId) throw new BadRequestException('Order ID wajib diisi untuk membuat review.');
    if (!Number.isInteger(rating) || rating < 1 || rating > 5) {
      throw new BadRequestException('Rating harus berupa bilangan bulat 1 sampai 5.');
    }
    const product = await this.prisma.product.findUnique({ where: { id: productId }, select: { id: true } });
    if (!product) throw new NotFoundException('Produk tidak ditemukan.');
    if (orderId) {
      const purchased = await this.prisma.orderItem.findFirst({ where: { orderId, productId, order: { userId } } });
      if (!purchased) throw new ForbiddenException('Review hanya dapat dibuat setelah membeli produk.');
    }
    return this.prisma.review.upsert({
      where: { userId_productId_orderId: { userId, productId, orderId: orderId ?? null } },
      create: { userId, productId, orderId, rating, comment },
      update: { rating, comment },
      include: { user: { select: { id: true, fullName: true } } },
    });
  }

  async validateVoucher(code: string, subtotal: number) {
    const voucher = await this.prisma.voucher.findUnique({ where: { code: code.trim().toUpperCase() } });
    const now = new Date();
    if (!voucher || !voucher.isActive || now < voucher.startsAt || now > voucher.expiresAt) {
      throw new BadRequestException('Voucher tidak valid atau sudah kedaluwarsa.');
    }
    if (voucher.usageLimit !== null && voucher.usedCount >= voucher.usageLimit) {
      throw new BadRequestException('Batas penggunaan voucher sudah tercapai.');
    }
    if (voucher.minPurchase !== null && subtotal < Number(voucher.minPurchase)) {
      throw new BadRequestException(`Minimal pembelian voucher adalah ${voucher.minPurchase}.`);
    }
    const rawDiscount = subtotal * voucher.discountPercent / 100;
    const discount = voucher.maxDiscount === null ? rawDiscount : Math.min(rawDiscount, Number(voucher.maxDiscount));
    return { code: voucher.code, discount, finalAmount: Math.max(0, subtotal - discount) };
  }

  async getAnalytics() {
    const [orders, users, products, revenue] = await Promise.all([
      this.prisma.order.count(),
      this.prisma.user.count(),
      this.prisma.product.count({ where: { isActive: true } }),
      this.prisma.order.aggregate({ _sum: { totalAmount: true }, where: { status: { not: 'CANCELLED' } } }),
    ]);
    return { orders, users, activeProducts: products, revenue: revenue._sum.totalAmount ?? 0 };
  }

  async getOrCreateConversation(userId: string, sellerId: string) {
    if (userId === sellerId) throw new BadRequestException('Customer dan seller harus berbeda.');
    const seller = await this.prisma.user.findFirst({ where: { id: sellerId, role: 'SELLER' }, select: { id: true } });
    if (!seller) throw new NotFoundException('Seller tidak ditemukan.');
    return this.prisma.chatConversation.upsert({
      where: { customerId_sellerId: { customerId: userId, sellerId } },
      create: { customerId: userId, sellerId },
      update: {},
      include: { messages: { orderBy: { createdAt: 'asc' } } },
    });
  }

  async listConversations(userId: string) {
    return this.prisma.chatConversation.findMany({
      where: { OR: [{ customerId: userId }, { sellerId: userId }] },
      include: { messages: { orderBy: { createdAt: 'desc' }, take: 1 } },
      orderBy: { updatedAt: 'desc' },
    });
  }

  async sendMessage(userId: string, conversationId: string, message: string) {
    const cleanMessage = message.trim();
    if (!cleanMessage || cleanMessage.length > 2000) throw new BadRequestException('Pesan harus 1-2000 karakter.');
    const conversation = await this.prisma.chatConversation.findFirst({ where: { id: conversationId, OR: [{ customerId: userId }, { sellerId: userId }] } });
    if (!conversation) throw new ForbiddenException('Anda tidak memiliki akses ke percakapan ini.');
    return this.prisma.$transaction([
      this.prisma.chatMessage.create({ data: { conversationId, senderId: userId, message: cleanMessage } }),
      this.prisma.chatConversation.update({ where: { id: conversationId }, data: { updatedAt: new Date() } }),
    ]).then(([created]) => created);
  }
}
