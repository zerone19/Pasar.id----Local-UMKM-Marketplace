'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { getToken, getUserRole } from '@/lib/auth';

interface Store {
  id: string;
  name: string;
  slug: string;
  description?: string;
  ownerId: string;
  createdAt: string;
  updatedAt: string;
}

export default function SellerStorePage() {
  const [store, setStore] = useState<Store | null>(null);
  const [loading, setLoading] = useState(true);
  const [saving, setSaving] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState<string | null>(null);

  const [formData, setFormData] = useState({
    name: '',
    slug: '',
    description: '',
  });

  useEffect(() => {
    const role = getUserRole();
    if (role !== 'SELLER' && role !== 'ADMIN') {
      setError('Akses ditolak. Anda harus login sebagai seller.');
      setLoading(false);
      return;
    }
    fetchStore();
  }, []);

  const fetchStore = async () => {
    try {
      const token = getToken();
      if (!token) {
        setError('Anda harus login terlebih dahulu.');
        setLoading(false);
        return;
      }
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      try {
        const response = await axios.get<Store>(`${apiUrl}/seller/store`, {
          headers: { Authorization: `Bearer ${token}` },
        });
        setStore(response.data);
        setFormData({
          name: response.data.name,
          slug: response.data.slug,
          description: response.data.description || '',
        });
      } catch (err: any) {
        if (err.response?.status === 404) {
          // No store yet — stay in create mode
        } else {
          throw err;
        }
      }
      setLoading(false);
    } catch (err: any) {
      console.error('Failed to fetch store:', err);
      setError(err.response?.data?.message || 'Gagal memuat toko.');
      setLoading(false);
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setSaving(true);
    setError(null);
    setSuccess(null);

    try {
      const token = getToken();
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      if (store) {
        await axios.put(
          `${apiUrl}/seller/store/${store.id}`,
          formData,
          { headers: { Authorization: `Bearer ${token}` } },
        );
        setSuccess('Toko berhasil diperbarui!');
      } else {
        await axios.post(
          `${apiUrl}/seller/store`,
          formData,
          { headers: { Authorization: `Bearer ${token}` } },
        );
        setSuccess('Toko berhasil dibuat!');
        window.location.href = '/seller/store';
      }
    } catch (err: any) {
      console.error('Failed to save store:', err);
      setError(err.response?.data?.message || 'Gagal menyimpan toko.');
    } finally {
      setSaving(false);
    }
  };

  if (loading) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
            <div className="animate-pulse">
              <div className="h-8 bg-surface-container-high rounded w-1/3 mb-6"></div>
              <div className="space-y-4">
                <div className="h-12 bg-surface-container-high rounded-lg"></div>
                <div className="h-12 bg-surface-container-high rounded-lg"></div>
                <div className="h-24 bg-surface-container-high rounded-lg"></div>
              </div>
            </div>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (error && !store) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
            <div className="text-center py-16">
              <span className="material-icons text-6xl text-error mb-4">lock</span>
              <p className="text-error font-label-md">{error}</p>
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
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <h1 className="font-headline-md text-2xl text-primary mb-2">
            {store ? 'Kelola Toko' : 'Buat Toko'}
          </h1>
          <p className="font-body-sm text-sm text-on-surface-variant mb-8">
            {store
              ? 'Perbarui informasi toko Anda di sini.'
              : 'Buat toko pertama Anda untuk mulai menjual.'}
          </p>

          {error && (
            <div className="mb-4 p-4 bg-error-container border border-error rounded-lg">
              <p className="text-error font-body-sm">{error}</p>
            </div>
          )}

          {success && (
            <div className="mb-4 p-4 bg-secondary/10 border border-secondary rounded-lg">
              <p className="text-secondary font-body-sm">{success}</p>
            </div>
          )}

          <form onSubmit={handleSubmit} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
            <div className="grid grid-cols-1 md:grid-cols-2 gap-6">
              <div>
                <label className="font-label-md text-sm text-on-surface block mb-2">
                  Nama Toko
                </label>
                <input
                  type="text"
                  required
                  value={formData.name}
                  onChange={(e) => setFormData({ ...formData, name: e.target.value })}
                  className="w-full px-4 py-3 bg-surface-container-high rounded-lg border border-outline-variant text-on-surface font-body-md focus:outline-none focus:ring-1 focus:ring-primary"
                  placeholder="Masukkan nama toko"
                />
              </div>

              <div>
                <label className="font-label-md text-sm text-on-surface block mb-2">
                  Slug (URL)
                </label>
                <input
                  type="text"
                  required
                  value={formData.slug}
                  onChange={(e) => setFormData({ ...formData, slug: e.target.value })}
                  className="w-full px-4 py-3 bg-surface-container-high rounded-lg border border-outline-variant text-on-surface font-body-md focus:outline-none focus:ring-1 focus:ring-primary"
                  placeholder="nama-toko-anda"
                />
                <p className="font-body-sm text-xs text-on-surface-variant mt-1">
                  Slug digunakan untuk URL toko Anda
                </p>
              </div>
            </div>

            <div className="mt-6">
              <label className="font-label-md text-sm text-on-surface block mb-2">
                Deskripsi Toko
              </label>
              <textarea
                value={formData.description}
                onChange={(e) => setFormData({ ...formData, description: e.target.value })}
                className="w-full px-4 py-3 bg-surface-container-high rounded-lg border border-outline-variant text-on-surface font-body-md focus:outline-none focus:ring-1 focus:ring-primary"
                placeholder="Deskripsi singkat tentang toko Anda..."
                rows={4}
              />
            </div>

            {store?.createdAt && (
              <div className="mt-6 pt-4 border-t border-outline-variant">
                <p className="font-body-sm text-xs text-on-surface-variant">
                  Dibuat pada: {new Date(store.createdAt).toLocaleDateString('id-ID')}
                </p>
                <p className="font-body-sm text-xs text-on-surface-variant mt-1">
                  Diperbarui pada: {new Date(store.updatedAt).toLocaleDateString('id-ID')}
                </p>
              </div>
            )}

            <div className="mt-6 flex justify-end gap-3">
              <button
                type="button"
                onClick={() => (window.location.href = '/seller')}
                className="px-4 py-2 border border-outline-variant rounded-lg text-on-surface font-label-md hover:bg-surface-container-high transition"
              >
                Batal
              </button>
              <button
                type="submit"
                disabled={saving}
                className="px-6 py-2 bg-primary text-white rounded-lg font-label-md hover:bg-primary/80 transition disabled:opacity-50"
              >
                {saving ? 'Menyimpan...' : store ? 'Simpan Perubahan' : 'Buat Toko'}
              </button>
            </div>
          </form>
        </div>
      </main>
      <Footer />
    </>
  );
}
