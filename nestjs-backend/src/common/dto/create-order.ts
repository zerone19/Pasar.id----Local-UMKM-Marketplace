import { IsString, IsArray, IsOptional } from 'class-validator';

export class CreateOrderDto {
  @IsString()
  userId!: string;

  @IsArray()
  items!: { productId: string; quantity: number }[];

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