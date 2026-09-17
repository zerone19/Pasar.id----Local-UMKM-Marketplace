import { IsString, IsNumber, IsOptional, IsArray, Min, IsEmail } from 'class-validator';

export class CreateProductDto {
  @IsString()
  name!: string;

  @IsString()
  slug!: string;

  @IsOptional()
  @IsString()
  description?: string;

  @IsNumber()
  @Min(0)
  price!: number;

  @IsNumber()
  @Min(0)
  stock!: number;

  @IsArray()
  @IsString({ each: true })
  images!: string[];

  @IsString()
  categoryId!: string;

  @IsString()
  sellerId!: string;
}
