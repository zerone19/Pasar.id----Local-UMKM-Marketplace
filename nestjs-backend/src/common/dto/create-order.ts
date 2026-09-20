import { IsString, IsArray, IsOptional, IsInt, Min } from 'class-validator';

export class CreateOrderItemDto {
  @IsString()
  productId!: string;

  @IsInt()
  @Min(1)
  quantity!: number;
}

export class CreateOrderDto {
  @IsOptional()
  @IsString()
  userId?: string;

  @IsArray()
  items!: CreateOrderItemDto[];

  @IsString()
  shippingAddress!: string;

  @IsOptional()
  @IsString()
  paymentMethod?: string;
}

export class UpdateOrderStatusDto {
  @IsString()
  status!: string;

  @IsOptional()
  @IsString()
  paymentStatus?: string;

  @IsOptional()
  @IsString()
  notes?: string;
}