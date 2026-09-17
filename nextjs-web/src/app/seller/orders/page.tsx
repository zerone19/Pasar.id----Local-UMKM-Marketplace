'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { getToken, getUserRole } from '@/lib/auth';

interface SellerOrderItem {
  id: string;
  quantity: number;
  price: number;
  orderId: string;
  productId: string;
  product: {
    id: string;
    name: string;
    images: string[];
  };
  order: {
    id: string;
    orderNumber: string;
    status: string;
    totalAmount: number;
    paymentMethod?: string;
    shippingAddress: string;
    createdAt: string;
    user: {
      id: string;
      fullName: string;
      email: string;
      phone?: string;
    };
  };
}

const statusOptions = [
  { value: 'PENDING', label: 'Menunggu Konfirmasi' },
  { value: 'CONFIRMED', label: 'Dikonfirmasi' },
  { value: 'PROCESSING', label: 'Diproses' },
  { value: 'READY', label: 'Siap Ambil' },
  { value: 'SHIPPED', label: 'Dikirim' },
  { value: 'COMPLETED', label: 'Selesai' },
  { value: 'CANCELLED', label: 'Dibatalkan' },
];

export default function SellerOrdersPage() {
  const [orders, setOrders] = useState<SellerOrderItem[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const role = getUserRole();
    if (role !== 'SELLER' && role !== 'ADMIN') {
      setError('Akses ditolak. Anda harus login sebagai seller.');
      setLoading(false);
      return;
    }
    fetchOrders();
  }, []);

  const fetchOrders = async () => {
    try {
      const token = getToken();
      if (!token) {
        setError('Anda harus login terlebih dahulu.');
        setLoading(false);
        return;
      }
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<SellerOrderItem[]>(`${apiUrl}/seller/orders`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setOrders(response.data);
      setLoading(false);
    } catch (err: any) {
      console.error('Failed to fetch orders:', err);
      setError(err.response?.data?.message || 'Gagal memuat pesanan.');
      setLoading(false);
    }
  };

  const updateStatus = async (orderItemId: string, orderId: string, status: string) => {
    try {
      const token = getToken();
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      await axios.put(
        `${apiUrl}/seller/orders/${orderItemId}/status`,
        { status },
        { headers: { Authorization: `Bearer ${token}` } },
      );
      fetchOrders();
    } catch (err: any) {
      console.error('Failed to update status:', err);
    }
  };

  const getStatusLabel = (status: string) => {
    return statusOptions.find((s) => s.value === status)?.label || status;
  };

  const getStatusColor = (status: string) => {
    switch (status) {
      case 'COMPLETED':
        return 'bg-secondary/10 text-secondary';
      case 'CANCELLED':
        return 'bg-error/10 text-error';
      case 'PENDING':
        return 'bg-tertiary/10 text-tertiary';
      default:
        return 'bg-surface-container-high text-on-surface-variant';
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
              <div className="space-y-4">
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
          <h1 className="font-headline-md text-2xl text-primary mb-2">Pesanan Masuk</h1>
          <p className="font-body-sm text-sm text-on-surface-variant mb-8">
            {orders.length} pesanan untuk produk Anda
          </p>

          {orders.length === 0 ? (
            <div className="text-center py-16">
              <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">
                shopping_bag
              </span>
              <p className="font-body-md text-lg text-on-surface-variant">
                Belum ada pesanan masuk.
              </p>
            </div>
          ) : (
            <div className="space-y-6">
              {orders.map((item) => (
                <div key={item.id} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-6 shadow-sm">
                  <div className="flex justify-between items-start mb-4">
                    <div>
                      <p className="font-label-md text-sm text-on-surface-variant">
                        Order #{item.order.orderNumber}
                      </p>
                      <p className="font-headline-md text-lg text-primary mt-1">
                        {item.product.name}
                      </p>
                    </div>
                    <span className={`px-3 py-1 rounded-full font-label-sm text-xs ${getStatusColor(item.order.status)}`}>
                      {getStatusLabel(item.order.status)}
                    </span>
                  </div>

                  <div className="grid grid-cols-1 md:grid-cols-3 gap-6 mb-4">
                    <div>
                      <p className="font-body-sm text-xs text-on-surface-variant">Jumlah</p>
                      <p className="font-label-md text-sm text-on-surface mt-1">{item.quantity}x</p>
                    </div>
                    <div>
                      <p className="font-body-sm text-xs text-on-surface-variant">Harga per unit</p>
                      <p className="font-label-md text-sm text-primary mt-1">Rp {formatPrice(item.price)}</p>
                    </div>
                    <div>
                      <p className="font-body-sm text-xs text-on-surface-variant">Total</p>
                      <p className="font-label-md text-sm text-primary mt-1">Rp {formatPrice(item.price * item.quantity)}</p>
                    </div>
                  </div>

                  <div className="border-t border-outline-variant pt-4">
                    <p className="font-body-sm text-xs text-on-surface-variant mb-2">Pembeli: {item.order.user.fullName} ({item.order.user.email})</p>
                    <p className="font-body-sm text-xs text-on-surface-variant">
                      Alamat: {item.order.shippingAddress}
                    </p>
                  </div>

                  <div className="mt-4">
                    <label className="font-body-sm text-xs text-on-surface-variant block mb-2">
                      Update Status Pesanan
                    </label>
                    <select
                      onChange={(e) => updateStatus(item.id, item.order.id, e.target.value)}
                      className="w-full md:w-auto px-3 py-2 bg-surface-container-high rounded-lg border border-outline-variant text-on-surface font-body-sm text-sm focus:outline-none focus:ring-1 focus:ring-primary"
                      defaultValue=""
                    >
                      <option value="" disabled>Pilih status baru</option>
                      {statusOptions.map((option) => (
                        <option key={option.value} value={option.value}>
                          {option.label}
                        </option>
                      ))}
                    </select>
                  </div>
                </div>
              ))}
            </div>
          )}
        </div>
      </main>
      <Footer />
    </>
  );
}
