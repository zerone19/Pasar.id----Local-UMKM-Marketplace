'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';
import Icon from '@/components/Icon';
import ProductCard from '@/components/ProductCard';

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

export default function ProductsPage() {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<{ data: Product[] }>(`${apiUrl}/products`);
      const activeProducts = response.data.data.filter((p) => p.isActive);
      setProducts(activeProducts);
      setLoading(false);
    } catch (err) {
      console.error('Failed to fetch products:', err);
      setError('Gagal memuat produk. Silakan coba lagi.');
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
            <h1 className="font-headline-md text-2xl text-primary mb-8">Semua Produk</h1>
            <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {[...Array(8)].map((_, i) => (
                <div key={i} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-4 shadow-sm animate-pulse">
                  <div className="h-48 bg-surface-container-high rounded-lg mb-4"></div>
                  <div className="h-4 bg-surface-container-high rounded mb-2"></div>
                  <div className="h-4 bg-surface-container-high rounded w-3/4 mb-2"></div>
                  <div className="h-4 bg-surface-container-high rounded w-1/2"></div>
                </div>
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
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
            <div className="text-center py-12">
              <Icon name="error" size={48} className="mb-4 text-error" />
              <p className="text-error font-label-md">{error}</p>
              <button
                onClick={fetchProducts}
                className="mt-4 bg-primary text-white px-6 py-2 rounded-lg hover:bg-primary/80 transition"
              >
                Coba Lagi
              </button>
            </div>
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
        {/* Header Section */}
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <h1 className="font-headline-md text-2xl text-primary mb-2">Semua Produk</h1>
          <p className="font-body-sm text-sm text-on-surface-variant">
            {products.length} produk tersedia
          </p>
        </section>

        {/* Product Grid */}
        <section className="px-5 md:px-8 max-w-7xl mx-auto pb-12">
          {products.length === 0 ? (
            <div className="text-center py-16">
              <Icon name="inventory_2" size={48} className="mb-4 text-on-surface-variant opacity-30" />
              <p className="font-body-md text-lg text-on-surface-variant">
                Belum ada produk tersedia
              </p>
              <p className="font-body-sm text-sm text-on-surface-variant mt-2">
                Cek kembali nanti untuk produk baru!
              </p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {products.map((product) => <ProductCard key={product.id} product={product} />)}
            </div>
          )}
        </section>
      </main>
      <Footer />
    </>
  );
}
