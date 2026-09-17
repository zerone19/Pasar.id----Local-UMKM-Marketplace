'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import AddToCartButton from '@/components/AddToCartButton';
import Link from 'next/link';

interface Category {
  id: string;
  name: string;
  slug: string;
}

interface Product {
  id: string;
  name: string;
  slug: string;
  description: string;
  price: number;
  images: string[];
  stock: number;
}

interface Store {
  id: string;
  name: string;
  slug: string;
  description: string;
  owner: {
    id: string;
    fullName: string;
    email: string;
  };
  products: Product[];
}

export default function StoreDetailPage({ params }: { params: { slug: string } }) {
  const [store, setStore] = useState<Store | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    if (params?.slug) {
      fetchStore(params.slug);
    }
  }, [params?.slug]);

  const fetchStore = async (slug: string) => {
    try {
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<Store>(`${apiUrl}/stores/slug/${slug}`);
      setStore(response.data);
      setLoading(false);
    } catch (err) {
      console.error('Failed to fetch store:', err);
      setError('Toko tidak ditemukan. Silakan coba lagi.');
      setLoading(false);
    }
  };

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('id-ID').format(price);
  };

  if (loading) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
            <div className="h-8 bg-surface-container-high rounded w-1/3 mb-6 animate-pulse"></div>
            <div className="h-6 bg-surface-container-high rounded w-1/2 mb-4 animate-pulse"></div>
            <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
              {[...Array(4)].map((_, i) => (
                <div key={i} className="h-40 bg-surface-container-high rounded-xl animate-pulse"></div>
              ))}
            </div>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (error) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-16 text-center">
            <span className="material-icons text-6xl text-error mb-4">error</span>
            <p className="text-error font-label-md mb-6">{error}</p>
            <Link
              href="/stores"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Kembali ke Semua UMKM
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (!store) return null;

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          {/* Store Header */}
          <div className="border-b border-outline-variant pb-8 mb-8">
            <nav className="mb-4">
              <Link href="/" className="text-on-surface-variant hover:text-primary font-body-sm">
                Beranda
              </Link>
              {' > '}
              <Link href="/stores" className="text-on-surface-variant hover:text-primary font-body-sm">
                UMKM
              </Link>
              {' > '}
              <span className="text-primary font-body-sm">{store.name}</span>
            </nav>

            <div className="flex items-start justify-between">
              <div>
                <h1 className="font-headline-md text-3xl text-on-surface mb-2">
                  {store.name}
                </h1>
                <p className="font-body-sm text-on-surface-variant mb-3">
                  Dikelola oleh: <span className="text-primary">{store.owner?.fullName || '-'}</span>
                </p>
              </div>
              <span className="material-icons text-4xl text-primary">
                storefront
              </span>
            </div>

            {store.description && (
              <p className="font-body-md text-on-surface-variant mt-4 max-w-2xl">
                {store.description}
              </p>
            )}
          </div>

          {/* Products Section */}
          <section>
            <h2 className="font-headline-md text-xl text-on-surface mb-6">
              Produk dari {store.name}
            </h2>

            {store.products && store.products.length === 0 ? (
              <div className="text-center py-12">
                <span className="material-icons text-4xl text-on-surface-variant mb-3 opacity-30">
                  inventory_2
                </span>
                <p className="font-body-md text-on-surface-variant">
                  Toko ini belum memiliki produk
                </p>
              </div>
            ) : (
              <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                {store.products?.map((product) => (
                  <div
                    key={product.id}
                    className="group bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden hover:shadow-organic hover:border-primary transition-all"
                  >
                    <div className="aspect-square h-48 bg-surface-container-high relative">
                      {product.images && product.images.length > 0 ? (
                        <img
                          src={product.images[0]}
                          alt={product.name}
                          className="w-full h-full object-cover"
                        />
                      ) : (
                        <div className="w-full h-full flex items-center justify-center">
                          <span className="material-icons text-3xl text-on-surface-variant opacity-30">
                            image
                          </span>
                        </div>
                      )}
                    </div>

                    <div className="p-4">
                      <h3 className="font-headline-md text-base text-on-surface group-hover:text-primary transition-colors line-clamp-1">
                        {product.name}
                      </h3>
                      <p className="font-label-md text-sm text-primary mt-1">
                        Rp {formatPrice(product.price)}
                      </p>
                      {product.stock > 0 ? (
                        <p className="font-body-sm text-xs text-secondary mt-1">
                          {product.stock} tersedia
                        </p>
                      ) : (
                        <p className="font-body-sm text-xs text-error mt-1">
                          Stok habis
                        </p>
                      )}

                      <div className="mt-3" onClick={(e) => e.stopPropagation()}>
                        <AddToCartButton
                          product={{
                            id: product.id,
                            slug: product.slug,
                            name: product.name,
                            price: product.price,
                            images: product.images,
                          }}
                          sellerName={store.owner?.fullName}
                          sellerId={store.owner?.id || ''}
                          disabled={product.stock === 0}
                        />
                      </div>
                    </div>
                  </div>
                ))}
              </div>
            )}
          </section>
        </div>
      </main>
      <Footer />
    </>
  );
}
