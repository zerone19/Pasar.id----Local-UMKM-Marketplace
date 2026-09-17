'use client';

import { useCart } from '@/contexts/CartContext';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

export default function CartPage() {
  const { items, itemCount, total, removeItem, updateQuantity, clearCart } = useCart();

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('id-ID').format(price);
  };

  if (items.length === 0) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-16 text-center">
            <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">
              shopping_basket
            </span>
            <h2 className="font-headline-md text-xl text-on-surface mb-2">
              Keranjang masih kosong
            </h2>
            <p className="font-body-sm text-on-surface-variant mb-6">
              Yuk cari produk yang kamu sukai!
            </p>
            <Link
              href="/products"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Cari Produk
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <h1 className="font-headline-md text-2xl text-primary mb-8">Keranjang Belanja</h1>

          <div className="space-y-4 mb-8">
            {items.map((item) => (
              <div
                key={item.productId}
                className="flex items-center gap-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-4"
              >
                <div className="w-20 h-20 bg-surface-container-high rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                  {item.image ? (
                    <img
                      src={item.image}
                      alt={item.name}
                      className="w-full h-full object-cover"
                    />
                  ) : (
                    <span className="material-icons text-3xl text-on-surface-variant opacity-30">
                      image
                    </span>
                  )}
                </div>

                <div className="flex-1 min-w-0">
                  <h3 className="font-headline-md text-base text-on-surface line-clamp-1">
                    {item.name}
                  </h3>
                  <p className="font-body-sm text-xs text-on-surface-variant">
                    Dari {item.storeName}
                  </p>
                  <p className="font-label-md text-sm text-primary mt-1">
                    Rp {formatPrice(item.price)} × {item.quantity}
                  </p>
                </div>

                <div className="flex items-center gap-2">
                  <div className="flex items-center border border-outline-variant rounded-lg bg-surface-container-lowest">
                    <button
                      onClick={() => updateQuantity(item.productId, item.quantity - 1)}
                      className="px-2 py-1 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-l transition"
                    >
                      <span className="material-icons text-sm">remove</span>
                    </button>
                    <span className="px-2 py-1 font-body-md text-on-surface min-w-[2rem] text-center text-sm">
                      {item.quantity}
                    </span>
                    <button
                      onClick={() => updateQuantity(item.productId, item.quantity + 1)}
                      className="px-2 py-1 text-on-surface-variant hover:text-on-surface hover:bg-surface-container-high rounded-r transition"
                    >
                      <span className="material-icons text-sm">add</span>
                    </button>
                  </div>

                  <button
                    onClick={() => removeItem(item.productId)}
                    className="text-error hover:text-error/70 p-1 transition"
                    title="Hapus dari keranjang"
                  >
                    <span className="material-icons text-sm">close</span>
                  </button>
                </div>
              </div>
            ))}
          </div>

          {/* Cart Summary */}
          <div className="border-t border-outline-variant pt-6 space-y-4">
            <div className="flex justify-between items-center pb-4 border-b border-outline-variant">
              <span className="font-body-md text-on-surface">Total ({itemCount} item)</span>
              <span className="font-headline-md text-xl text-primary">
                Rp {formatPrice(total)}
              </span>
            </div>

            <div className="flex gap-4 items-center">
              <button
                onClick={clearCart}
                className="flex-1 border border-outline-variant text-on-surface py-2 px-4 rounded-lg font-label-md hover:bg-surface-container-high transition"
              >
                Kosongkan Keranjang
              </button>
              <Link
                href="/checkout"
                className="flex-1 bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md text-center hover:bg-primary/80 transition"
              >
                Lanjut ke Pembayaran
              </Link>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
