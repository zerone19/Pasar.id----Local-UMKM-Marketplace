import {
  Body,
  Controller,
  Get,
  Param,
  ParseBoolPipe,
  ParseEnumPipe,
  ParseIntPipe,
  Put,
  Query,
  Req,
  UseGuards,
} from '@nestjs/common';
import { Request } from 'express';
import { OrderStatus, Role } from '@prisma/client';
import { JwtAuthGuard } from '../auth/jwt-auth.guard';
import { RolesGuard } from '../../common/guards/roles.guard';
import { Roles } from '../../common/decorators/roles.decorator';
import { AdminService } from './admin.service';

@Controller('admin')
@UseGuards(JwtAuthGuard, RolesGuard)
@Roles(Role.ADMIN)
export class AdminController {
  constructor(private readonly adminService: AdminService) {}

  private getUserId(req: Request): string {
    const user = req.user as { id?: string; userId?: string };
    return user.id ?? user.userId ?? '';
  }

  @Get('dashboard')
  getDashboard() {
    return this.adminService.getDashboard();
  }

  @Get('users')
  getUsers(
    @Query('page', new ParseIntPipe({ optional: true })) page?: number,
    @Query('limit', new ParseIntPipe({ optional: true })) limit?: number,
  ) {
    return this.adminService.listUsers({ page, limit });
  }

  @Put('users/:id/role')
  updateUserRole(
    @Req() req: Request,
    @Param('id') id: string,
    @Body('role', new ParseEnumPipe(Role)) role: Role,
  ) {
    return this.adminService.updateUserRole(id, role, this.getUserId(req));
  }

  @Get('products')
  getProducts(
    @Query('page', new ParseIntPipe({ optional: true })) page?: number,
    @Query('limit', new ParseIntPipe({ optional: true })) limit?: number,
  ) {
    return this.adminService.listProducts({ page, limit });
  }

  @Put('products/:id/moderation')
  moderateProduct(
    @Param('id') id: string,
    @Body('isActive', ParseBoolPipe) isActive: boolean,
  ) {
    return this.adminService.moderateProduct(id, isActive);
  }

  @Get('orders')
  getOrders(
    @Query('page', new ParseIntPipe({ optional: true })) page?: number,
    @Query('limit', new ParseIntPipe({ optional: true })) limit?: number,
  ) {
    return this.adminService.listOrders({ page, limit });
  }

  @Put('orders/:id/status')
  updateOrderStatus(
    @Param('id') id: string,
    @Body('status', new ParseEnumPipe(OrderStatus)) status: OrderStatus,
    @Body('paymentStatus') paymentStatus?: string,
  ) {
    return this.adminService.updateOrderStatus(id, status, paymentStatus);
  }
}
