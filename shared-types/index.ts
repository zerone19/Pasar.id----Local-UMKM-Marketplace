export interface User {
  id: string;
  email: string;
  fullName: string;
  role: string;
  phone?: string;
  address?: string;
  createdAt: Date;
  updatedAt: Date;
}

export interface Product {
  id: string;
  name: string;
  slug: string;
  description?: string;
  price: number;
  stock: number;
  images: string[];
  categoryId: string;
  sellerId: string;
  isActive: boolean;
}

export interface Store {
  id: string;
  name: string;
  slug: string;
  description?: string;
  ownerId: string;
}

export interface Order {
  id: string;
  orderNumber: string;
  status: string;
  totalAmount: number;
  paymentMethod?: string;
  paymentStatus: string;
  userId: string;
  shippingAddress: string;
}

export interface PaginatedResult<T> {
  data: T[];
  meta: {
    total: number;
    page: number;
    limit: number;
    totalPages: number;
  };
}
