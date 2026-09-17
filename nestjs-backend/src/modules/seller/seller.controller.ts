import {
  Controller,
  Get,
  Post,
  Put,
  Delete,
  Body,
  Param,
  Req,
  UseGuards,
  HttpCode,
  HttpStatus,
} from '@nestjs/common';
import { JwtAuthGuard } from '../auth/jwt-auth.guard';
import { RolesGuard } from '../../common/guards/roles.guard';
import { Roles } from '../../common/decorators/roles.decorator';
import { Role } from '@prisma/client';
import { SellerService } from './seller.service';
import { Request } from 'express';

@Controller('seller')
@UseGuards(JwtAuthGuard, RolesGuard)
export class SellerController {
  constructor(private readonly sellerService: SellerService) {}

  private getUserId(req: Request): string {
    return (req.user as any).userId;
  }

  // ── Dashboard ──
  @Get('dashboard')
  @Roles(Role.SELLER, Role.ADMIN)
  async getDashboard(@Req() req: Request) {
    const userId = this.getUserId(req);
    return await this.sellerService.getDashboardStats(userId);
  }

  // ── Products ──
  @Get('products')
  @Roles(Role.SELLER, Role.ADMIN)
  async getProducts(@Req() req: Request) {
    const userId = this.getUserId(req);
    return await this.sellerService.getSellerProducts(userId);
  }

  @Get('products/:id')
  @Roles(Role.SELLER, Role.ADMIN)
  async getProduct(@Req() req: Request, @Param('id') id: string) {
    const userId = this.getUserId(req);
    return await this.sellerService.getSellerProduct(userId, id);
  }

  @Post('products')
  @Roles(Role.SELLER, Role.ADMIN)
  async createProduct(@Req() req: Request, @Body() body: any) {
    const userId = this.getUserId(req);
    return await this.sellerService.createProduct(userId, body);
  }

  @Put('products/:id')
  @Roles(Role.SELLER, Role.ADMIN)
  async updateProduct(
    @Req() req: Request,
    @Param('id') id: string,
    @Body() body: any,
  ) {
    const userId = this.getUserId(req);
    return await this.sellerService.updateProduct(userId, id, body);
  }

  @Delete('products/:id')
  @HttpCode(HttpStatus.NO_CONTENT)
  @Roles(Role.SELLER, Role.ADMIN)
  async deleteProduct(@Req() req: Request, @Param('id') id: string) {
    const userId = this.getUserId(req);
    return await this.sellerService.deleteProduct(userId, id);
  }

  // ── Orders ──
  @Get('orders')
  @Roles(Role.SELLER, Role.ADMIN)
  async getOrders(@Req() req: Request) {
    const userId = this.getUserId(req);
    return await this.sellerService.getSellerOrders(userId);
  }

  @Get('orders/:id')
  @Roles(Role.SELLER, Role.ADMIN)
  async getOrder(@Req() req: Request, @Param('id') id: string) {
    const userId = this.getUserId(req);
    return await this.sellerService.getOrderById(userId, id);
  }

  @Put('orders/:id/status')
  @Roles(Role.SELLER, Role.ADMIN)
  async updateOrderStatus(
    @Req() req: Request,
    @Param('id') id: string,
    @Body() body: { status: string },
  ) {
    return await this.sellerService.updateOrderStatus(id, body.status);
  }

  // ── Store Management ──
  @Get('store')
  @Roles(Role.SELLER, Role.ADMIN)
  async getStore(@Req() req: Request) {
    const userId = this.getUserId(req);
    return await this.sellerService.getSellerStore(userId);
  }

  @Post('store')
  @Roles(Role.SELLER, Role.ADMIN)
  async createStore(@Req() req: Request, @Body() body: any) {
    const userId = this.getUserId(req);
    return await this.sellerService.createStore(userId, body);
  }

  @Put('store/:id')
  @Roles(Role.SELLER, Role.ADMIN)
  async updateStore(
    @Req() req: Request,
    @Param('id') id: string,
    @Body() body: any,
  ) {
    const userId = this.getUserId(req);
    return await this.sellerService.updateStore(userId, id, body);
  }
}
