'use client';

import { useCart } from '@/contexts/CartContext';
import { useState } from 'react';

interface AddToCartButtonProps {
  product: {
    id: string;
    slug: string;
    name: string;
    price: number;
    images: string[];
  };
  sellerName?: string;
  sellerId: string;
  disabled?: boolean;
}

export default function AddToCartButton({
  product,
  sellerName = 'Toko Pasar.ID',
  sellerId,
  disabled,
}: AddToCartButtonProps) {
  const { addItem, items } = useCart();
  const [quantity, setQuantity] = useState(1);
  const [added, setAdded] = useState(false);

  const inCart = items.find((item) => item.productId === product.id);

  const handleAdd = () => {
    addItem(
      {
        productId: product.id,
        slug: product.slug,
        name: product.name,
        price: product.price,
        image: product.images?.[0] || '',
        storeName: sellerName,
        sellerId,
      },
      quantity,
    );
    setAdded(true);
    setTimeout(() => setAdded(false), 2000);
  };

  if (disabled) {
    return (
      <button
        disabled
        className="w-full bg-outline text-on-surface py-3 px-6 rounded-lg font-label-md text-center cursor-not-allowed"
      >
        Stok Habis
      </button>
    );
  }

  return (
    <div className="flex gap-3">
      <div className="flex items-center border border-outline-variant rounded-lg bg-surface-container-lowest">
        <button
          type="button"
          onClick={() => setQuantity(Math.max(1, quantity - 1))}
          className="px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-l-lg transition"
        >
          <span className="material-icons text-sm">remove</span>
        </button>
        <span className="px-3 py-1 font-body-md text-on-surface min-w-[3rem] text-center">
          {quantity}
        </span>
        <button
          type="button"
          onClick={() => setQuantity(quantity + 1)}
          className="px-3 py-2 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-r-lg transition"
        >
          <span className="material-icons text-sm">add</span>
        </button>
      </div>

      <button
        onClick={handleAdd}
        className={`flex-1 py-3 px-6 rounded-lg font-label-md transition flex items-center justify-center gap-2 ${
          inCart
            ? 'bg-secondary text-on-secondary hover:bg-secondary/80'
            : 'bg-primary text-on-primary hover:bg-primary/80'
        }`}
      >
        <span className="material-icons text-sm">
          {inCart ? 'done' : 'shopping_cart'}
        </span>
        {added ? 'Ditambahkan!' : inCart ? 'Di Keranjang' : 'Tambah ke Keranjang'}
      </button>
    </div>
  );
}
