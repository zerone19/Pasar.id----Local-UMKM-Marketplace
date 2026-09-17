import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

@Injectable()
export class CategoriesService {
  constructor(private readonly prisma: PrismaService) {}

  async findAll() {
    return this.prisma.category.findMany({
      include: {
        _count: {
          select: { products: true },
        },
      },
      orderBy: { name: 'asc' },
    });
  }

  async findById(id: string) {
    const category = await this.prisma.category.findUnique({
      where: { id },
      include: {
        _count: {
          select: { products: true },
        },
      },
    });
    if (!category) throw new NotFoundException('Kategori tidak ditemukan');
    return category;
  }

  async findBySlug(slug: string) {
    const category = await this.prisma.category.findUnique({
      where: { slug },
      include: {
        _count: {
          select: { products: true },
        },
      },
    });
    if (!category) throw new NotFoundException('Kategori tidak ditemukan');
    return category;
  }

  async create(dto: { name: string; slug: string; description?: string }) {
    return this.prisma.category.create({ data: dto });
  }

  async update(id: string, dto: { name?: string; slug?: string; description?: string }) {
    await this.findById(id);
    return this.prisma.category.update({
      where: { id },
      data: dto,
    });
  }

  async delete(id: string) {
    await this.findById(id);
    return this.prisma.category.delete({ where: { id } });
  }
}