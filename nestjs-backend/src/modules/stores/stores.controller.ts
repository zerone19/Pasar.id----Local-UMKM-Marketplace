import { Controller, Get, Param, Post, Body } from '@nestjs/common';
import { StoresService } from './stores.service';
import { CreateStoreDto } from '../../common/dto/create-store';

@Controller('stores')
export class StoresController {
  constructor(private readonly storesService: StoresService) {}

  @Get()
  async findAll() {
    return this.storesService.findAll();
  }

  @Get('slug/:slug')
  async findBySlug(@Param('slug') slug: string) {
    return this.storesService.findBySlug(slug);
  }

  @Get(':id')
  async findOne(@Param('id') id: string) {
    return this.storesService.findById(id);
  }

  @Post()
  async create(@Body() dto: CreateStoreDto) {
    return this.storesService.create(dto);
  }
}
