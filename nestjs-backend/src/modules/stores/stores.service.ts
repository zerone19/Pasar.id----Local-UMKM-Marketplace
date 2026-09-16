import { Injectable, NotFoundException } from '@nestjs/common';
import { PrismaService } from '../../prisma/prisma.service';

@Injectable()
export class StoresService {
  constructor(private readonly prisma: PrismaService) {}

  async findAll() {
    return this.prisma.store.findMany({ include: { owner: true, products: true } });
  }

  async findById(id: string) {
    const store = await this.prisma.store.findUnique({ where: { id }, include: { owner: true } });
    if (!store) throw new NotFoundException('Store tidak ditemukan');
    return store;
  }

  async create(dto: { name: string; slug: string; description?: string; ownerId: string }) {
    return this.prisma.store.create({ data: dto });
  }
}
