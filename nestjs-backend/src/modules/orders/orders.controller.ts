import { Controller, Get, Param, Post, Body } from '@nestjs/common';
import { OrdersService } from './orders.service';
import { CreateOrderDto } from '../../common/dto/create-order';

@Controller('orders')
export class OrdersController {
  constructor(private readonly ordersService: OrdersService) {}

  @Get()
  async findAll() {
    return this.ordersService.findAll();
  }

  @Get(':id')
  async findOne(@Param('id') id: string) {
    return this.ordersService.findById(id);
  }

  @Post()
  async create(@Body() dto: CreateOrderDto) {
    return this.ordersService.create(dto);
  }
}
