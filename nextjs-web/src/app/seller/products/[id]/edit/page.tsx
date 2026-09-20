'use client';

import { useEffect, useState } from 'react';
import { useParams, useRouter } from 'next/navigation';
import axios from 'axios';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { getToken, getUserRole } from '@/lib/auth';

export default function EditProductPage() {
  const params = useParams<{ id: string }>();
  const router = useRouter();
  const [form, setForm] = useState({ name: '', description: '', price: '', stock: '', isActive: true });
  const [error, setError] = useState('');

  useEffect(() => {
    if (!['SELLER', 'ADMIN'].includes(getUserRole() || '')) { setError('Akses ditolak.'); return; }
    axios.get(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000'}/seller/products/${params.id}`, { headers: { Authorization: `Bearer ${getToken()}` } })
      .then((r) => setForm({ name: r.data.name, description: r.data.description || '', price: String(r.data.price), stock: String(r.data.stock), isActive: r.data.isActive }))
      .catch((e) => setError(e.response?.data?.message || 'Produk tidak ditemukan.'));
  }, [params.id]);

  const submit = async (e: React.FormEvent) => {
    e.preventDefault(); setError('');
    try {
      await axios.put(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000'}/seller/products/${params.id}`, { ...form, price: Number(form.price), stock: Number(form.stock) }, { headers: { Authorization: `Bearer ${getToken()}` } });
      router.push('/seller/products');
    } catch (e: any) { setError(e.response?.data?.message || 'Gagal memperbarui produk.'); }
  };

  return <><Header /><main className="min-h-screen bg-cream py-12"><div className="max-w-2xl mx-auto px-5 md:px-8"><h1 className="text-2xl text-primary font-headline-md mb-6">Edit Produk</h1>{error && <p className="text-error mb-4">{error}</p>}<form onSubmit={submit} className="space-y-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-6"><input required value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} className="w-full p-3 border rounded-lg" /><textarea value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })} className="w-full p-3 border rounded-lg" /><input required type="number" min="0" value={form.price} onChange={(e) => setForm({ ...form, price: e.target.value })} className="w-full p-3 border rounded-lg" /><input required type="number" min="0" value={form.stock} onChange={(e) => setForm({ ...form, stock: e.target.value })} className="w-full p-3 border rounded-lg" /><label className="flex gap-2"><input type="checkbox" checked={form.isActive} onChange={(e) => setForm({ ...form, isActive: e.target.checked })} /> Produk aktif</label><button className="bg-primary text-white px-5 py-3 rounded-lg">Simpan Perubahan</button></form></div></main><Footer /></>;
}
