export class CreateOrderDto {
  userId!: string;
  items!: { productId: string; quantity: number }[];
  shippingAddress!: string;
  paymentMethod?: string;
}
