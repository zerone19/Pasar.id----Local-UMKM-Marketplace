'use client';

import { useEffect, useState } from 'react';
import { useRouter } from 'next/navigation';
import axios from 'axios';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { getToken, getUserRole } from '@/lib/auth';

export default function NewProductPage() {
  const router = useRouter();
  const [categories, setCategories] = useState<any[]>([]);
  const [form, setForm] = useState({ name: '', description: '', price: '', stock: '', categoryId: '', images: '' });
  const [error, setError] = useState('');

  useEffect(() => {
    if (!['SELLER', 'ADMIN'].includes(getUserRole() || '')) { setError('Akses ditolak.'); return; }
    axios.get(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000'}/categories`).then((r) => setCategories(r.data));
  }, []);

  const submit = async (e: React.FormEvent) => {
    e.preventDefault(); setError('');
    try {
      await axios.post(`${process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000'}/seller/products`, {
        name: form.name, description: form.description, price: Number(form.price), stock: Number(form.stock),
        categoryId: form.categoryId, images: form.images ? form.images.split(',').map((s) => s.trim()) : [],
      }, { headers: { Authorization: `Bearer ${getToken()}` } });
      router.push('/seller/products');
    } catch (err: any) { setError(err.response?.data?.message || 'Gagal membuat produk.'); }
  };

  return <><Header /><main className="min-h-screen bg-cream py-12"><div className="max-w-2xl mx-auto px-5 md:px-8"><h1 className="text-2xl text-primary font-headline-md mb-6">Tambah Produk</h1>{error && <p className="text-error mb-4">{error}</p>}<form onSubmit={submit} className="space-y-4 bg-surface-container-lowest border border-outline-variant rounded-xl p-6"><input required placeholder="Nama produk" value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} className="w-full p-3 border rounded-lg" /><textarea placeholder="Deskripsi" value={form.description} onChange={(e) => setForm({ ...form, description: e.target.value })} className="w-full p-3 border rounded-lg" /><select required value={form.categoryId} onChange={(e) => setForm({ ...form, categoryId: e.target.value })} className="w-full p-3 border rounded-lg"><option value="">Pilih kategori</option>{categories.map((c) => <option key={c.id} value={c.id}>{c.name}</option>)}</select><input required type="number" min="0" placeholder="Harga" value={form.price} onChange={(e) => setForm({ ...form, price: e.target.value })} className="w-full p-3 border rounded-lg" /><input required type="number" min="0" placeholder="Stok" value={form.stock} onChange={(e) => setForm({ ...form, stock: e.target.value })} className="w-full p-3 border rounded-lg" /><input placeholder="URL gambar (pisahkan dengan koma)" value={form.images} onChange={(e) => setForm({ ...form, images: e.target.value })} className="w-full p-3 border rounded-lg" /><button className="bg-primary text-white px-5 py-3 rounded-lg">Simpan Produk</button></form></div></main><Footer /></>;
}
