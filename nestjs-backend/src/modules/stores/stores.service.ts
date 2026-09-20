import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

@Injectable()
export class StoresService {
  constructor(private readonly prisma: PrismaService) {}

  private readonly ownerSelect = {
    id: true,
    fullName: true,
    email: true,
    phone: true,
  };

  async findAll() {
    return this.prisma.store.findMany({
      include: {
        owner: { select: this.ownerSelect },
        products: true,
      },
    });
  }

  async findById(id: string) {
    const store = await this.prisma.store.findUnique({
      where: { id },
      include: { owner: { select: this.ownerSelect } },
    });
    if (!store) throw new NotFoundException('Store tidak ditemukan');
    return store;
  }

  async findBySlug(slug: string) {
    const store = await this.prisma.store.findUnique({
      where: { slug },
      include: {
        owner: { select: this.ownerSelect },
        products: { include: { category: true } },
      },
    });
    if (!store) throw new NotFoundException('Store tidak ditemukan');
    return store;
  }

  async create(dto: { name: string; slug: string; description?: string; ownerId: string }) {
    return this.prisma.store.create({ data: dto });
  }
}
