export class CreateProductDto {
  name!: string;
  slug!: string;
  description?: string;
  price!: number;
  stock!: number;
  images!: string[];
  categoryId!: string;
  sellerId!: string;
}
