import { IsString, IsOptional, IsArray, IsNumber, ValidateNested } from 'class-validator';
import { Type } from 'class-transformer';

class OrderItemDto {
  @IsString()
  productId!: string;

  @IsNumber()
  quantity!: number;
}

export class CreateOrderDto {
  @IsString()
  userId!: string;

  @IsArray()
  @ValidateNested({ each: true })
  @Type(() => OrderItemDto)
  items!: { productId: string; quantity: number }[];

  @IsString()
  shippingAddress!: string;

  @IsOptional()
  @IsString()
  paymentMethod?: string;
}
