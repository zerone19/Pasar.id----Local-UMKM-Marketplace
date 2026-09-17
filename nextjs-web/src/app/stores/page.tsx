'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

interface User {
  id: string;
  fullName: string;
  email: string;
}

interface Product {
  id: string;
  name: string;
}

interface Store {
  id: string;
  name: string;
  slug: string;
  description: string;
  owner: User;
  products: Product[];
}

export default function StoresPage() {
  const [stores, setStores] = useState<Store[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    fetchStores();
  }, []);

  const fetchStores = async () => {
    try {
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<Store[]>(`${apiUrl}/stores`);
      setStores(response.data);
      setLoading(false);
    } catch (err) {
      console.error('Failed to fetch stores:', err);
      setError('Gagal memuat toko. Silakan coba lagi.');
      setLoading(false);
    }
  };

  if (loading) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
            <h1 className="font-headline-md text-2xl text-primary mb-8">UMKM Terdaftar</h1>
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              {[...Array(6)].map((_, i) => (
                <div key={i} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 animate-pulse">
                  <div className="h-6 bg-surface-container-high rounded mb-3"></div>
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
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-16 text-center">
            <span className="material-icons text-6xl text-error mb-4">error</span>
            <p className="text-error font-label-md mb-6">{error}</p>
            <button
              onClick={fetchStores}
              className="bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Coba Lagi
            </button>
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
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <h1 className="font-headline-md text-2xl text-primary mb-2">UMKM Terdaftar</h1>
          <p className="font-body-sm text-sm text-on-surface-variant mb-8">
            {stores.length} toko mitra lokal
          </p>

          {stores.length === 0 ? (
            <div className="text-center py-16">
              <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">
                storefront
              </span>
              <p className="font-body-md text-lg text-on-surface-variant">
                Belum ada toko terdaftar
              </p>
              <p className="font-body-sm text-sm text-on-surface-variant mt-2">
                Jadilah mitra pertama kami!
              </p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              {stores.map((store) => (
                <Link
                  key={store.id}
                  href={`/stores/${store.slug}`}
                  className="group block bg-surface-container-lowest border border-outline-variant rounded-xl p-6 hover:shadow-organic hover:border-primary transition-all"
                >
                  <div className="flex items-start justify-between mb-3">
                    <h3 className="font-headline-md text-lg text-on-surface group-hover:text-primary transition-colors line-clamp-1">
                      {store.name}
                    </h3>
                    <span className="material-icons text-on-surface-variant text-sm">
                      arrow_forward
                    </span>
                  </div>
                  <p className="font-body-sm text-sm text-on-surface-variant mb-3 line-clamp-2">
                    {store.description || 'Toko UMKM lokal'}
                  </p>
                  <div className="flex items-center justify-between">
                    <span className="font-label-sm text-xs text-on-surface-variant">
                      {store.products?.length || 0} produk
                    </span>
                    <span className="font-label-sm text-xs text-secondary bg-secondary-container px-2 py-1 rounded-full">
                      Dari {store.owner?.fullName || '-'}
                    </span>
                  </div>
                </Link>
              ))}
            </div>
          )}
        </section>
      </main>
      <Footer />
    </>
  );
}
