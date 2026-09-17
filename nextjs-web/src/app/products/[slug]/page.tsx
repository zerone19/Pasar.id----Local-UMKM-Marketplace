'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import { useRouter } from 'next/navigation';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import AddToCartButton from '@/components/AddToCartButton';
import Link from 'next/link';

interface Category {
  id: string;
  name: string;
  slug: string;
}

interface Seller {
  id: string;
  fullName: string;
  email: string;
}

interface Product {
  id: string;
  name: string;
  slug: string;
  price: number;
  description: string;
  images: string[];
  isActive: boolean;
  createdAt: string;
  category: Category;
  seller: Seller;
}

export default function ProductDetailPage({ params }: { params: { slug: string } }) {
  const [product, setProduct] = useState<Product | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  useEffect(() => {
    if (params?.slug) {
      fetchProduct(params.slug);
    }
  }, [params?.slug]);

  const fetchProduct = async (slug: string) => {
    try {
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<Product>(`${apiUrl}/products/slug/${slug}`);
      setProduct(response.data);
      setLoading(false);
    } catch (err) {
      console.error('Failed to fetch product:', err);
      setError('Produk tidak ditemukan. Silakan coba lagi.');
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
            <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
              <div className="h-80 bg-surface-container-high rounded-xl animate-pulse"></div>
              <div className="space-y-4">
                <div className="h-8 bg-surface-container-high rounded w-3/4 animate-pulse"></div>
                <div className="h-6 bg-surface-container-high rounded w-1/4 animate-pulse"></div>
                <div className="h-24 bg-surface-container-high rounded animate-pulse"></div>
                <div className="h-12 bg-surface-container-high rounded w-1/3 animate-pulse"></div>
              </div>
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
              href="/products"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg hover:bg-primary/80 transition"
            >
              Kembali ke Semua Produk
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (!product) return null;

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <nav className="mb-8">
            <Link href="/" className="text-on-surface-variant hover:text-primary font-body-sm">
              Beranda
            </Link>
            {' > '}
            <Link href="/products" className="text-on-surface-variant hover:text-primary font-body-sm">
              Semua Produk
            </Link>
            {' > '}
            <span className="text-primary font-body-sm">{product.name}</span>
          </nav>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {/* Product Images */}
            <div className="space-y-4">
              <div className="aspect-square h-80 bg-surface-container-high rounded-xl overflow-hidden border border-outline-variant">
                {product.images && product.images.length > 0 ? (
                  <img
                    src={product.images[0]}
                    alt={product.name}
                    className="w-full h-full object-cover"
                  />
                ) : (
                  <div className="w-full h-full flex items-center justify-center">
                    <span className="material-icons text-6xl text-on-surface-variant opacity-30">
                      image
                    </span>
                  </div>
                )}
              </div>
              {product.images && product.images.length > 1 && (
                <div className="flex gap-2 overflow-x-auto">
                  {product.images.slice(1).map((img, i) => (
                    <img
                      key={i}
                      src={img}
                      alt={`${product.name} ${i + 2}`}
                      className="w-20 h-20 object-cover rounded-lg border border-outline-variant"
                    />
                  ))}
                </div>
              )}
            </div>

            {/* Product Info */}
            <div className="space-y-6">
              <div>
                <h1 className="font-headline-md text-3xl text-on-surface mb-2">
                  {product.name}
                </h1>
                <p className="font-body-sm text-sm text-on-surface-variant mb-4">
                  Dari {product.seller?.fullName || 'Penjual'}
                </p>
                <p className="font-label-md text-xl text-primary mb-4">
                  Rp {formatPrice(product.price)}
                </p>
                <span className={`inline-block px-3 py-1 rounded-full font-body-sm text-xs ${
                  product.stock > 0
                    ? 'bg-secondary-container text-on-secondary-container'
                    : 'bg-error-container text-on-error'
                }`}>
                  {product.stock > 0 ? `${product.stock} tersedia` : 'Habis'}
                </span>
              </div>

              <div className="border-t border-outline-variant pt-6">
                <h3 className="font-headline-md text-lg text-on-surface mb-3">Deskripsi</h3>
                <p className="font-body-md text-on-surface-variant leading-relaxed">
                  {product.description || 'Tidak ada deskripsi untuk produk ini.'}
                </p>
              </div>

              <div className="border-t border-outline-variant pt-6">
                <p className="font-body-sm text-on-surface-variant">
                  Kategori: <span className="text-primary">{product.category?.name || '-'}</span>
                </p>
              </div>

              <div className="pt-6">
                <AddToCartButton
                  product={{
                    id: product.id,
                    slug: product.slug,
                    name: product.name,
                    price: product.price,
                    images: product.images,
                  }}
                  sellerName={product.seller?.fullName}
                  sellerId={product.seller?.id || ''}
                  disabled={product.stock === 0}
                />
              </div>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
