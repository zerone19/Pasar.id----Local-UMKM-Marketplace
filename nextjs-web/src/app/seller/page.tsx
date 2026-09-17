'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';
import { getToken, getUserRole } from '@/lib/auth';

interface DashboardStats {
  totalProducts: number;
  totalStock: number;
  totalOrders: number;
  totalRevenue: number;
  totalSold: number;
  lowStock: number;
}

export default function SellerDashboardPage() {
  const [stats, setStats] = useState<DashboardStats | null>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const role = getUserRole();
    if (role !== 'SELLER' && role !== 'ADMIN') {
      setError('Akses ditolak. Anda harus login sebagai seller.');
      setLoading(false);
      return;
    }
    fetchStats();
  }, []);

  const fetchStats = async () => {
    try {
      const token = getToken();
      if (!token) {
        setError('Anda harus login terlebih dahulu.');
        setLoading(false);
        return;
      }
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<DashboardStats>(`${apiUrl}/seller/dashboard`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setStats(response.data);
      setLoading(false);
    } catch (err: any) {
      console.error('Failed to fetch dashboard stats:', err);
      setError(err.response?.data?.message || 'Gagal memuat dashboard.');
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
            <div className="animate-pulse space-y-6">
              <div className="h-8 bg-surface-container-high rounded w-1/3 mb-6"></div>
              <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-4">
                {[...Array(6)].map((_, i) => (
                  <div key={i} className="h-24 bg-surface-container-high rounded-xl"></div>
                ))}
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
          <h1 className="font-headline-md text-2xl text-primary mb-2">Seller Dashboard</h1>
          <p className="font-body-sm text-sm text-on-surface-variant mb-8">
            Kelola toko, produk, dan pesanan Anda di sini.
          </p>

          {/* Stats Grid */}
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-12">
            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Total Produk</p>
                  <p className="font-headline-md text-2xl text-primary mt-1">{stats?.totalProducts}</p>
                </div>
                <span className="material-icons text-3xl text-primary/20">inventory_2</span>
              </div>
            </div>

            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Stok Tersedia</p>
                  <p className="font-headline-md text-2xl text-primary mt-1">{stats?.totalStock}</p>
                </div>
                <span className="material-icons text-3xl text-primary/20">warehouse</span>
              </div>
            </div>

            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Total Pesanan</p>
                  <p className="font-headline-md text-2xl text-primary mt-1">{stats?.totalOrders}</p>
                </div>
                <span className="material-icons text-3xl text-primary/20">shopping_bag</span>
              </div>
            </div>

            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Total Penjualan</p>
                  <p className="font-headline-md text-2xl text-primary mt-1">
                    Rp {formatPrice(stats?.totalRevenue || 0)}
                  </p>
                </div>
                <span className="material-icons text-3xl text-primary/20">attach_money</span>
              </div>
            </div>

            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Terjual</p>
                  <p className="font-headline-md text-2xl text-primary mt-1">{stats?.totalSold}</p>
                </div>
                <span className="material-icons text-3xl text-primary/20">local_offer</span>
              </div>
            </div>

            <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
              <div className="flex items-center justify-between">
                <div>
                  <p className="font-body-sm text-xs text-on-surface-variant uppercase">Stok Rendah</p>
                  <p className="font-headline-md text-2xl text-error mt-1">{stats?.lowStock}</p>
                </div>
                <span className="material-icons text-3xl text-error/20">warning</span>
              </div>
            </div>
          </div>

          {/* Quick Actions */}
          <div className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm mb-8">
            <h2 className="font-headline-md text-lg text-primary mb-4">Aksi Cepat</h2>
            <div className="grid grid-cols-1 md:grid-cols-4 gap-4">
              <Link href="/seller/products" className="flex items-center gap-3 bg-primary hover:bg-primary/80 text-white py-3 px-4 rounded-lg transition">
                <span className="material-icons">inventory_2</span>
                <span>Produk Saya</span>
              </Link>
              <Link href="/seller/orders" className="flex items-center gap-3 bg-secondary hover:bg-secondary/80 text-white py-3 px-4 rounded-lg transition">
                <span className="material-icons">shopping_bag</span>
                <span>Pesanan Saya</span>
              </Link>
              <Link href="/seller/store" className="flex items-center gap-3 bg-tertiary hover:bg-tertiary/80 text-white py-3 px-4 rounded-lg transition">
                <span className="material-icons">store</span>
                <span>Toko Saya</span>
              </Link>
              <Link href="/products" className="flex items-center gap-3 bg-surface-container hover:bg-surface-container-high text-on-surface py-3 px-4 rounded-lg transition">
                <span className="material-icons">add</span>
                <span>Tambah Produk</span>
              </Link>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
