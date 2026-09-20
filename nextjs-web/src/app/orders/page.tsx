'use client';

import { useEffect, useState } from 'react';
import axios from 'axios';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';
import { getToken, getUser } from '@/lib/auth';

export default function OrdersPage() {
  const [orders, setOrders] = useState<any[]>([]);
  const [error, setError] = useState('');

  useEffect(() => {
    const user = getUser();
    const token = getToken();
    if (!user || !token) { setError('Silakan login untuk melihat pesanan.'); return; }
    axios.get(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000'}/orders/user/${user.id}`, { headers: { Authorization: `Bearer ${token}` } })
      .then((r) => setOrders(r.data)).catch((e) => setError(e.response?.data?.message || 'Gagal memuat pesanan.'));
  }, []);

  return <><Header /><main className="min-h-screen bg-cream py-12"><div className="max-w-5xl mx-auto px-5 md:px-8"><h1 className="text-2xl text-primary font-headline-md mb-6">Riwayat Pesanan</h1>{error ? <p className="text-error">{error}</p> : orders.length === 0 ? <p className="text-on-surface-variant">Belum ada pesanan.</p> : <div className="space-y-4">{orders.map((order) => <div key={order.id} className="bg-surface-container-lowest border border-outline-variant rounded-xl p-5"><div className="flex justify-between gap-4"><div><h2 className="font-label-md text-primary">{order.orderNumber}</h2><p className="text-sm text-on-surface-variant">{new Date(order.createdAt).toLocaleDateString('id-ID')}</p></div><span className="px-3 py-1 rounded-full bg-primary/10 text-primary text-sm">{order.status}</span></div><p className="mt-3 text-on-surface">{order.items?.length || 0} item · Rp {new Intl.NumberFormat('id-ID').format(Number(order.totalAmount))}</p><Link href={`/checkout/success?orderId=${order.id}`} className="inline-block mt-3 text-primary underline">Lihat detail</Link></div>)}</div>}</div></main><Footer /></>;
}
