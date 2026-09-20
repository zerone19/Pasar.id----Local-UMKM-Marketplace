import {
  BadRequestException,
  ConflictException,
  Injectable,
  NotFoundException,
} from '@nestjs/common';
import { OrderStatus, Prisma, Role } from '@prisma/client';
import { PrismaService } from '../../prisma/prisma.service';

const userSelect = {
  id: true,
  email: true,
  fullName: true,
  role: true,
  phone: true,
  address: true,
  createdAt: true,
  updatedAt: true,
} satisfies Prisma.UserSelect;

const productSelect = {
  id: true,
  name: true,
  slug: true,
  description: true,
  price: true,
  stock: true,
  images: true,
  isActive: true,
  createdAt: true,
  updatedAt: true,
  category: { select: { id: true, name: true, slug: true } },
  seller: { select: { id: true, fullName: true, email: true } },
  store: { select: { id: true, name: true, slug: true } },
} satisfies Prisma.ProductSelect;

const orderSelect = {
  id: true,
  orderNumber: true,
  status: true,
  totalAmount: true,
  paymentMethod: true,
  paymentStatus: true,
  shippingAddress: true,
  createdAt: true,
  updatedAt: true,
  user: { select: { id: true, fullName: true, email: true } },
  items: {
    select: {
      id: true,
      quantity: true,
      price: true,
      product: { select: { id: true, name: true, sellerId: true } },
    },
  },
} satisfies Prisma.OrderSelect;

type PageParams = { page?: number; limit?: number };

@Injectable()
export class AdminService {
  constructor(private readonly prisma: PrismaService) {}

  private paginate({ page = 1, limit = 20 }: PageParams) {
    const safePage = Number.isFinite(page) ? Math.max(1, Math.floor(page)) : 1;
    const safeLimit = Number.isFinite(limit)
      ? Math.min(100, Math.max(1, Math.floor(limit)))
      : 20;
    return { page: safePage, limit: safeLimit, skip: (safePage - 1) * safeLimit };
  }

  async getDashboard() {
    const [users, sellers, products, inactiveProducts, orders, revenue] = await Promise.all([
      this.prisma.user.count(),
      this.prisma.user.count({ where: { role: Role.SELLER } }),
      this.prisma.product.count(),
      this.prisma.product.count({ where: { isActive: false } }),
      this.prisma.order.count(),
      this.prisma.order.aggregate({
        _sum: { totalAmount: true },
        where: { status: { not: OrderStatus.CANCELLED } },
      }),
    ]);

    return {
      users,
      sellers,
      products,
      inactiveProducts,
      orders,
      totalRevenue: revenue._sum.totalAmount ?? 0,
    };
  }

  async listUsers(params: PageParams) {
    const { page, limit, skip } = this.paginate(params);
    const [data, total] = await Promise.all([
      this.prisma.user.findMany({ select: userSelect, orderBy: { createdAt: 'desc' }, skip, take: limit }),
      this.prisma.user.count(),
    ]);
    return { data, meta: { total, page, limit, totalPages: Math.ceil(total / limit) } };
  }

  async updateUserRole(id: string, role: Role, currentUserId: string) {
    if (!Object.values(Role).includes(role)) {
      throw new BadRequestException('Role tidak valid.');
    }
    const user = await this.prisma.user.findUnique({ where: { id }, select: { id: true, role: true } });
    if (!user) throw new NotFoundException('User tidak ditemukan.');
    if (id === currentUserId && role !== Role.ADMIN) {
      throw new BadRequestException('Admin aktif tidak dapat menurunkan role dirinya sendiri.');
    }
    if (user.role === Role.ADMIN && role !== Role.ADMIN) {
      const adminCount = await this.prisma.user.count({ where: { role: Role.ADMIN } });
      if (adminCount <= 1) throw new ConflictException('Admin terakhir tidak dapat diturunkan role-nya.');
    }
    return this.prisma.user.update({ where: { id }, data: { role }, select: userSelect });
  }

  async listProducts(params: PageParams) {
    const { page, limit, skip } = this.paginate(params);
    const [data, total] = await Promise.all([
      this.prisma.product.findMany({ select: productSelect, orderBy: { createdAt: 'desc' }, skip, take: limit }),
      this.prisma.product.count(),
    ]);
    return { data, meta: { total, page, limit, totalPages: Math.ceil(total / limit) } };
  }

  async moderateProduct(id: string, isActive: boolean) {
    const product = await this.prisma.product.findUnique({ where: { id }, select: { id: true } });
    if (!product) throw new NotFoundException('Produk tidak ditemukan.');
    return this.prisma.product.update({ where: { id }, data: { isActive }, select: productSelect });
  }

  async listOrders(params: PageParams) {
    const { page, limit, skip } = this.paginate(params);
    const [data, total] = await Promise.all([
      this.prisma.order.findMany({ select: orderSelect, orderBy: { createdAt: 'desc' }, skip, take: limit }),
      this.prisma.order.count(),
    ]);
    return { data, meta: { total, page, limit, totalPages: Math.ceil(total / limit) } };
  }

  async updateOrderStatus(id: string, status: OrderStatus, paymentStatus?: string) {
    if (!Object.values(OrderStatus).includes(status)) {
      throw new BadRequestException('Status pesanan tidak valid.');
    }
    const order = await this.prisma.order.findUnique({ where: { id }, select: { id: true } });
    if (!order) throw new NotFoundException('Pesanan tidak ditemukan.');
    return this.prisma.order.update({
      where: { id },
      data: { status, ...(paymentStatus !== undefined ? { paymentStatus } : {}) },
      select: orderSelect,
    });
  }
}
