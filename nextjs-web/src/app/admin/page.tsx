'use client';

import { useEffect, useState } from 'react';
import axios from 'axios';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import { getToken, getUserRole } from '@/lib/auth';

type Dashboard = {
  users: number;
  sellers: number;
  products: number;
  inactiveProducts: number;
  orders: number;
  totalRevenue: number | string;
};

type AdminUser = { id: string; email: string; fullName: string; role: 'BUYER' | 'SELLER' | 'ADMIN' };
type AdminProduct = { id: string; name: string; isActive: boolean; seller?: { fullName: string }; category?: { name: string } };
type AdminOrder = { id: string; orderNumber: string; status: string; totalAmount: number | string; user?: { fullName: string; email: string } };

const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';

export default function AdminPage() {
  const [dashboard, setDashboard] = useState<Dashboard | null>(null);
  const [users, setUsers] = useState<AdminUser[]>([]);
  const [products, setProducts] = useState<AdminProduct[]>([]);
  const [orders, setOrders] = useState<AdminOrder[]>([]);
  const [tab, setTab] = useState<'users' | 'products' | 'orders'>('users');
  const [error, setError] = useState<string | null>(null);
  const [loading, setLoading] = useState(true);

  const headers = () => ({ Authorization: `Bearer ${getToken()}` });

  useEffect(() => {
    if (getUserRole() !== 'ADMIN') {
      setError('Akses ditolak. Halaman ini hanya untuk admin.');
      setLoading(false);
      return;
    }
    void loadData();
  }, []);

  async function loadData() {
    try {
      const config = { headers: headers() };
      const [dashboardResponse, usersResponse, productsResponse, ordersResponse] = await Promise.all([
        axios.get<Dashboard>(`${apiUrl}/admin/dashboard`, config),
        axios.get<{ data: AdminUser[] }>(`${apiUrl}/admin/users?limit=50`, config),
        axios.get<{ data: AdminProduct[] }>(`${apiUrl}/admin/products?limit=50`, config),
        axios.get<{ data: AdminOrder[] }>(`${apiUrl}/admin/orders?limit=50`, config),
      ]);
      setDashboard(dashboardResponse.data);
      setUsers(usersResponse.data.data);
      setProducts(productsResponse.data.data);
      setOrders(ordersResponse.data.data);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Gagal memuat data admin.');
    } finally {
      setLoading(false);
    }
  }

  async function changeRole(user: AdminUser, role: AdminUser['role']) {
    try {
      const response = await axios.put<AdminUser>(`${apiUrl}/admin/users/${user.id}/role`, { role }, { headers: headers() });
      setUsers((current) => current.map((item) => item.id === user.id ? response.data : item));
    } catch (err: any) {
      setError(err.response?.data?.message || 'Role user gagal diperbarui.');
    }
  }

  async function moderateProduct(product: AdminProduct) {
    try {
      const response = await axios.put<AdminProduct>(
        `${apiUrl}/admin/products/${product.id}/moderation`,
        { isActive: !product.isActive },
        { headers: headers() },
      );
      setProducts((current) => current.map((item) => item.id === product.id ? response.data : item));
      setDashboard((current) => current ? { ...current, inactiveProducts: current.inactiveProducts + (product.isActive ? 1 : -1) } : current);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Moderasi produk gagal.');
    }
  }

  if (loading) return <><Header /><main className="min-h-screen bg-cream p-8">Memuat dashboard admin...</main><Footer /></>;
  if (error && !dashboard) return <><Header /><main className="min-h-screen bg-cream p-8"><p className="text-error">{error}</p></main><Footer /></>;

  return (
    <><Header /><main className="min-h-screen bg-cream pb-16"><div className="max-w-7xl mx-auto px-5 md:px-8 py-10">
      <h1 className="text-3xl font-headline-md text-primary">Admin Dashboard</h1>
      <p className="text-on-surface-variant mt-2 mb-8">Kelola pengguna, produk, dan pesanan marketplace.</p>
      {error && <p className="mb-4 rounded-lg bg-error/10 p-3 text-error">{error}</p>}
      <div className="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        {[
          ['Users', dashboard?.users], ['Seller', dashboard?.sellers], ['Produk', dashboard?.products],
          ['Moderasi', dashboard?.inactiveProducts], ['Pesanan', dashboard?.orders],
          ['Revenue', `Rp ${Number(dashboard?.totalRevenue || 0).toLocaleString('id-ID')}`],
        ].map(([label, value]) => <div key={String(label)} className="rounded-xl bg-surface-container-lowest border border-outline-variant p-4"><p className="text-xs text-on-surface-variant">{label}</p><p className="text-xl font-bold text-primary mt-1">{value}</p></div>)}
      </div>
      <div className="flex gap-2 border-b border-outline-variant mb-5">
        {(['users', 'products', 'orders'] as const).map((item) => <button key={item} onClick={() => setTab(item)} className={`px-4 py-3 capitalize ${tab === item ? 'border-b-2 border-primary text-primary font-bold' : 'text-on-surface-variant'}`}>{item}</button>)}
      </div>
      <div className="overflow-x-auto rounded-xl bg-surface-container-lowest border border-outline-variant">
        {tab === 'users' && <table className="w-full text-sm"><thead><tr className="text-left border-b border-outline-variant"><th className="p-4">Nama</th><th>Email</th><th>Role</th></tr></thead><tbody>{users.map((user) => <tr key={user.id} className="border-b border-outline-variant"><td className="p-4">{user.fullName}</td><td>{user.email}</td><td><select value={user.role} onChange={(event) => void changeRole(user, event.target.value as AdminUser['role'])} className="rounded border p-1"><option>BUYER</option><option>SELLER</option><option>ADMIN</option></select></td></tr>)}</tbody></table>}
        {tab === 'products' && <table className="w-full text-sm"><thead><tr className="text-left border-b border-outline-variant"><th className="p-4">Produk</th><th>Seller</th><th>Status</th><th>Aksi</th></tr></thead><tbody>{products.map((product) => <tr key={product.id} className="border-b border-outline-variant"><td className="p-4">{product.name}</td><td>{product.seller?.fullName || '-'}</td><td>{product.isActive ? 'Aktif' : 'Nonaktif'}</td><td><button onClick={() => void moderateProduct(product)} className="text-primary underline">{product.isActive ? 'Nonaktifkan' : 'Aktifkan'}</button></td></tr>)}</tbody></table>}
        {tab === 'orders' && <table className="w-full text-sm"><thead><tr className="text-left border-b border-outline-variant"><th className="p-4">Order</th><th>Pembeli</th><th>Status</th><th>Total</th></tr></thead><tbody>{orders.map((order) => <tr key={order.id} className="border-b border-outline-variant"><td className="p-4">{order.orderNumber}</td><td>{order.user?.fullName || order.user?.email || '-'}</td><td>{order.status}</td><td>Rp {Number(order.totalAmount).toLocaleString('id-ID')}</td></tr>)}</tbody></table>}
      </div>
    </div></main><Footer /></>
  );
}
