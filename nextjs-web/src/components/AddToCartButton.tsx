'use client';

import { useCart } from '@/contexts/CartContext';
import { useState } from 'react';
import Icon from '@/components/Icon';

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
    <div className="grid grid-cols-[auto_minmax(0,1fr)] items-stretch gap-2">
      <div className="flex h-11 items-center rounded-lg border border-outline-variant bg-surface-container-lowest">
        <button
          type="button"
          aria-label="Kurangi jumlah"
          disabled={quantity === 1}
          onClick={() => setQuantity(Math.max(1, quantity - 1))}
          className="flex h-full w-9 items-center justify-center rounded-l-lg text-on-surface-variant transition hover:bg-surface-container-high hover:text-on-surface disabled:cursor-not-allowed disabled:opacity-35"
        >
          <Icon name="remove" size={15} />
        </button>
        <span aria-label={`Jumlah ${quantity}`} className="flex h-full min-w-8 items-center justify-center border-x border-outline-variant px-1 text-sm font-semibold text-on-surface">
          {quantity}
        </span>
        <button
          type="button"
          aria-label="Tambah jumlah"
          onClick={() => setQuantity(quantity + 1)}
          className="flex h-full w-9 items-center justify-center rounded-r-lg text-on-surface-variant transition hover:bg-surface-container-high hover:text-on-surface"
        >
          <Icon name="add" size={15} />
        </button>
      </div>

      <button
        type="button"
        onClick={handleAdd}
        className={`flex h-11 min-w-0 items-center justify-center gap-1.5 whitespace-nowrap rounded-lg px-3 text-xs font-semibold transition sm:text-sm ${
          inCart
            ? 'bg-secondary text-on-secondary hover:bg-secondary/80'
            : 'bg-primary text-on-primary hover:bg-primary/80'
        }`}
      >
        <Icon name={inCart ? 'check' : 'shopping_cart'} size={16} />
        <span className="truncate">{added ? 'Ditambahkan' : inCart ? 'Di Keranjang' : 'Tambah ke Keranjang'}</span>
      </button>
    </div>
  );
}
