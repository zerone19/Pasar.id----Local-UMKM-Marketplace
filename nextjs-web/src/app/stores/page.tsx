'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import StoreCard from '@/components/StoreCard';

interface User {
  id: string;
  email: string;
  fullName: string;
  role: string;
}

interface Store {
  id: string;
  name: string;
  slug: string;
  description?: string;
  ownerId: string;
  owner: User;
  products: { id: string }[];
  createdAt: string;
  updatedAt: string;
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
            <h1 className="font-headline-md text-2xl text-primary mb-2">Daftar Toko</h1>
            <p className="font-body-sm text-sm text-on-surface-variant mb-8">
              Temukan UMKM lokal pilihan
            </p>
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {[...Array(8)].map((_, i) => (
                <div key={i} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-5 shadow-sm animate-pulse">
                  <div className="flex items-start justify-between mb-2">
                    <div className="w-10 h-10 bg-surface-container-high rounded-full"></div>
                    <div className="h-5 bg-surface-container-high rounded-full w-16"></div>
                  </div>
                  <div className="h-5 bg-surface-container-high rounded mb-2"></div>
                  <div className="h-4 bg-surface-container-high rounded mb-2 w-3/4"></div>
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
              <span className="material-icons text-6xl text-error mb-4">error</span>
              <p className="text-error font-label-md">{error}</p>
              <button
                onClick={fetchStores}
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
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <h1 className="font-headline-md text-2xl text-primary mb-2">Daftar Toko</h1>
          <p className="font-body-sm text-sm text-on-surface-variant">
            {stores.length} toko tersedia
          </p>
        </section>

        <section className="px-5 md:px-8 max-w-7xl mx-auto pb-12">
          {stores.length === 0 ? (
            <div className="text-center py-16">
              <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">
                store
              </span>
              <p className="font-body-md text-lg text-on-surface-variant">
                Belum ada toko tersedia
              </p>
              <p className="font-body-sm text-sm text-on-surface-variant mt-2">
                Cek kembali nanti untuk toko baru!
              </p>
            </div>
          ) : (
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
              {stores.map((store) => (
                <StoreCard
                  key={store.id}
                  id={store.id}
                  name={store.name}
                  slug={store.slug}
                  description={store.description}
                  ownerName={store.owner?.fullName || 'Anonim'}
                  productCount={store.products?.length || 0}
                />
              ))}
            </div>
          )}
        </section>
      </main>
      <Footer />
    </>
  );
}
