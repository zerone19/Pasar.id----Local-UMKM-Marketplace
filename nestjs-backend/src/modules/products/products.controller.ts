import { Controller, Get, Param, Post, Body } from '@nestjs/common';
import { ProductsService } from './products.service';
import { CreateProductDto } from '../../common/dto/create-product';

@Controller('products')
export class ProductsController {
  constructor(private readonly productsService: ProductsService) {}

  @Get()
  async findAll() {
    return this.productsService.findAll();
  }

  @Get(':id')
  async findOne(@Param('id') id: string) {
    return this.productsService.findById(id);
  }

  @Post()
  async create(@Body() dto: CreateProductDto) {
    const data = { ...dto, slug: dto.slug || dto.name.toLowerCase().replace(/\s+/g, '-') };
    return this.productsService.create(data);
  }
}
