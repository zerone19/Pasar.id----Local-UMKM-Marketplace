import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

interface ProductFilters {
  category?: string;
  search?: string;
  minPrice?: number;
  maxPrice?: number;
  page?: number;
  limit?: number;
  sortBy?: 'name' | 'price' | 'createdAt';
  sortOrder?: 'asc' | 'desc';
}

@Injectable()
export class ProductsService {
  constructor(private readonly prisma: PrismaService) {}

  async findAll(filters: ProductFilters = {}) {
    const {
      category,
      search,
      minPrice,
      maxPrice,
      page = 1,
      limit = 20,
      sortBy = 'createdAt',
      sortOrder = 'desc',
    } = filters;

    const where: any = { isActive: true };

    if (category) {
      where.category = { slug: category };
    }

    if (search) {
      where.OR = [
        { name: { contains: search, mode: 'insensitive' } },
        { description: { contains: search, mode: 'insensitive' } },
      ];
    }

    if (minPrice !== undefined || maxPrice !== undefined) {
      where.price = {};
      if (minPrice !== undefined) where.price.gte = minPrice;
      if (maxPrice !== undefined) where.price.lte = maxPrice;
    }

    const productInclude = {
      category: true,
      store: { select: { id: true, name: true, slug: true, description: true } },
      seller: { select: { id: true, fullName: true, email: true, phone: true } },
    };

    const [products, total] = await Promise.all([
      this.prisma.product.findMany({
        where,
        include: productInclude,
        orderBy: { [sortBy]: sortOrder },
        skip: (page - 1) * limit,
        take: limit,
      }),
      this.prisma.product.count({ where }),
    ]);

    return {
      data: products,
      meta: {
        total,
        page,
        limit,
        totalPages: Math.ceil(total / limit),
      },
    };
  }

  async findById(id: string) {
    const product = await this.prisma.product.findFirst({
      where: { id, isActive: true },
      include: {
        category: true,
        store: { select: { id: true, name: true, slug: true, description: true } },
        seller: { select: { id: true, fullName: true, email: true, phone: true } },
      },
    });
    if (!product) throw new NotFoundException('Product tidak ditemukan');
    return product;
  }

  async findBySlug(slug: string) {
    const product = await this.prisma.product.findFirst({
      where: { slug, isActive: true },
      include: {
        category: true,
        store: { select: { id: true, name: true, slug: true, description: true } },
        seller: { select: { id: true, fullName: true, email: true, phone: true } },
      },
    });
    if (!product) throw new NotFoundException('Product tidak ditemukan');
    return product;
  }

  async create(data: { name: string; slug: string; description?: string; price: number; stock: number; images: string[]; categoryId: string; sellerId: string; storeId?: string }) {
    return this.prisma.product.create({ data });
  }
}
