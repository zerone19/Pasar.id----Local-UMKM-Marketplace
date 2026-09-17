import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

@Injectable()
export class ProductsService {
  constructor(private readonly prisma: PrismaService) {}

  async findAll() {
    return this.prisma.product.findMany({
      include: { category: true, seller: true },
      where: { isActive: true },
    });
  }

  async findById(id: string) {
    const product = await this.prisma.product.findUnique({
      where: { id },
      include: { category: true, seller: true },
    });
    if (!product) throw new NotFoundException('Product tidak ditemukan');
    return product;
  }

  async findBySlug(slug: string) {
    const product = await this.prisma.product.findUnique({
      where: { slug },
      include: { category: true, seller: true },
    });
    if (!product) throw new NotFoundException('Product tidak ditemukan');
    return product;
  }

  async create(data: { name: string; slug: string; description?: string; price: number; stock: number; images: string[]; categoryId: string; sellerId: string; storeId?: string }) {
    return this.prisma.product.create({ data });
  }
}
