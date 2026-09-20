import {
  Controller,
  Get,
  Param,
  Post,
  Body,
  Put,
  Req,
  UseGuards,
  ForbiddenException,
} from '@nestjs/common';
import { OrdersService } from './orders.service';
import { CreateOrderDto, UpdateOrderStatusDto } from '../../common/dto/create-order';
import { OrderStatus, Role } from '@prisma/client';
import { JwtAuthGuard } from '../auth/jwt-auth.guard';
import { Request } from 'express';

@Controller('orders')
@UseGuards(JwtAuthGuard)
export class OrdersController {
  constructor(private readonly ordersService: OrdersService) {}

  @Get()
  async findAll(@Req() req: Request) {
    const user = req.user as any;
    if (user.role !== Role.ADMIN) {
      throw new ForbiddenException('Hanya admin yang dapat melihat seluruh pesanan.');
    }
    return this.ordersService.findAll();
  }

  @Get('user/:userId')
  async findByUser(@Req() req: Request, @Param('userId') userId: string) {
    const user = req.user as any;
    const currentUserId = user.id ?? user.userId;
    if (currentUserId !== userId && user.role !== Role.ADMIN) {
      throw new ForbiddenException('Anda tidak berhak melihat pesanan pengguna lain.');
    }
    return this.ordersService.findByUser(userId);
  }

  @Get(':id')
  async findOne(@Req() req: Request, @Param('id') id: string) {
    const order = await this.ordersService.findById(id);
    const user = req.user as any;
    const currentUserId = user.id ?? user.userId;
    if (user.role !== Role.ADMIN && order.userId !== currentUserId) {
      // Check if user is a seller who has products in this order
      const hasSellerProduct = order.items.some(
        (item: any) => item.product?.sellerId === user.userId,
      );
      if (!hasSellerProduct) {
        throw new ForbiddenException('Anda tidak berhak mengakses pesanan ini.');
      }
    }
    return order;
  }

  @Post()
  async create(@Req() req: Request, @Body() dto: CreateOrderDto) {
    const user = req.user as any;
    const userId = dto.userId && dto.userId.trim() !== '' ? dto.userId : user.userId;
    return this.ordersService.create({
      ...dto,
      userId,
    });
  }

  @Put(':id/status')
  async updateStatus(
    @Req() req: Request,
    @Param('id') id: string,
    @Body() dto: UpdateOrderStatusDto,
  ) {
    const user = req.user as any;
    if (user.role !== Role.ADMIN && user.role !== Role.SELLER) {
      throw new ForbiddenException('Hanya seller atau admin yang dapat mengubah status pesanan.');
    }
    if (user.role !== Role.ADMIN) {
      const order = await this.ordersService.findById(id);
      const currentUserId = user.id ?? user.userId;
      if (order.userId !== currentUserId) {
        const ownsProduct = order.items.some(
          (item: any) => item.product?.sellerId === currentUserId,
        );
        if (!ownsProduct) {
          throw new ForbiddenException('Anda tidak berhak mengubah pesanan ini.');
        }
      }
    }
    return this.ordersService.updateStatus(
      id,
      dto.status as OrderStatus,
      dto.paymentStatus,
      dto.notes,
    );
  }
}
