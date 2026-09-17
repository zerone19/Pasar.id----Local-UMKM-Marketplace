'use client';

import axios from 'axios';
import { useState, useEffect } from 'react';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';
import { getToken, getUserRole } from '@/lib/auth';

interface Category {
  id: string;
  name: string;
  slug: string;
}

interface Store {
  id: string;
  name: string;
  slug: string;
}

interface Product {
  id: string;
  name: string;
  slug: string;
  price: number;
  stock: number;
  images: string[];
  isActive: boolean;
  createdAt: string;
  category: Category;
  store?: Store;
}

export default function SellerProductsPage() {
  const [products, setProducts] = useState<Product[]>([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  useEffect(() => {
    const role = getUserRole();
    if (role !== 'SELLER' && role !== 'ADMIN') {
      setError('Akses ditolak. Anda harus login sebagai seller.');
      setLoading(false);
      return;
    }
    fetchProducts();
  }, []);

  const fetchProducts = async () => {
    try {
      const token = getToken();
      if (!token) {
        setError('Anda harus login terlebih dahulu.');
        setLoading(false);
        return;
      }
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      const response = await axios.get<Product[]>(`${apiUrl}/seller/products`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setProducts(response.data);
      setLoading(false);
    } catch (err: any) {
      console.error('Failed to fetch products:', err);
      setError(err.response?.data?.message || 'Gagal memuat produk.');
      setLoading(false);
    }
  };

  const toggleActive = async (product: Product) => {
    try {
      const token = getToken();
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      await axios.put(
        `${apiUrl}/seller/products/${product.id}`,
        { isActive: !product.isActive },
        { headers: { Authorization: `Bearer ${token}` } },
      );
      setProducts((prev) =>
        prev.map((p) =>
          p.id === product.id ? { ...p, isActive: !product.isActive } : p,
        ),
      );
    } catch (err: any) {
      console.error('Failed to update product:', err);
    }
  };

  const deleteProduct = async (id: string) => {
    if (!confirm('Yakin ingin menghapus produk ini?')) return;
    try {
      const token = getToken();
      const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
      await axios.delete(`${apiUrl}/seller/products/${id}`, {
        headers: { Authorization: `Bearer ${token}` },
      });
      setProducts((prev) => prev.filter((p) => p.id !== id));
    } catch (err: any) {
      console.error('Failed to delete product:', err);
      setError('Gagal menghapus produk.');
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
                  <div key={i} className="h-20 bg-surface-container-high rounded-xl"></div>
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
          <div className="flex justify-between items-center mb-6">
            <h1 className="font-headline-md text-2xl text-primary">Produk Saya</h1>
            <Link
              href="/seller/products/new"
              className="bg-primary text-white px-4 py-2 rounded-lg hover:bg-primary/80 transition flex items-center gap-2"
            >
              <span className="material-icons text-sm">add</span>
              Tambah Produk
            </Link>
          </div>
          <p className="font-body-sm text-sm text-on-surface-variant mb-6">
            {products.length} produk terdaftar
          </p>

          {products.length === 0 ? (
            <div className="text-center py-16">
              <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">
                inventory_2
              </span>
              <p className="font-body-md text-lg text-on-surface-variant">
                Belum ada produk. Tambahkan produk pertama Anda!
              </p>
            </div>
          ) : (
            <div className="overflow-x-auto">
              <table className="w-full bg-surface-container-lowest border border-outline-variant rounded-xl overflow-hidden">
                <thead className="bg-surface-container-high">
                  <tr>
                    <th className="text-left font-label-md text-xs text-on-surface-variant uppercase p-4">Produk</th>
                    <th className="text-left font-label-md text-xs text-on-surface-variant uppercase p-4">Kategori</th>
                    <th className="text-right font-label-md text-xs text-on-surface-variant uppercase p-4">Harga</th>
                    <th className="text-center font-label-md text-xs text-on-surface-variant uppercase p-4">Stok</th>
                    <th className="text-center font-label-md text-xs text-on-surface-variant uppercase p-4">Status</th>
                    <th className="text-center font-label-md text-xs text-on-surface-variant uppercase p-4">Aksi</th>
                  </tr>
                </thead>
                <tbody>
                  {products.map((product) => (
                    <tr key={product.id} className="border-t border-outline-variant">
                      <td className="p-4">
                        <div className="flex items-center gap-3">
                          <div className="w-12 h-12 bg-surface-container-high rounded-lg overflow-hidden flex-shrink-0">
                            {product.images && product.images.length > 0 ? (
                              <img
                                src={product.images[0]}
                                alt={product.name}
                                className="w-full h-full object-cover"
                              />
                            ) : (
                              <div className="w-full h-full flex items-center justify-center">
                                <span className="material-icons text-primary">image</span>
                              </div>
                            )}
                          </div>
                          <div>
                            <p className="font-label-md text-sm text-on-surface">{product.name}</p>
                            <p className="font-body-sm text-xs text-on-surface-variant">
                              Ditambahkan {new Date(product.createdAt).toLocaleDateString('id-ID')}
                            </p>
                          </div>
                        </div>
                      </td>
                      <td className="p-4">
                        <span className="font-body-sm text-sm text-on-surface-variant">
                          {product.category?.name || '-'}
                        </span>
                      </td>
                      <td className="p-4 text-right">
                        <span className="font-label-md text-sm text-primary">
                          Rp {formatPrice(product.price)}
                        </span>
                      </td>
                      <td className="p-4 text-center">
                        <span className={`font-label-md text-sm ${
                          product.stock <= 5 ? 'text-error' : 'text-on-surface'
                        }`}>
                          {product.stock}
                        </span>
                      </td>
                      <td className="p-4 text-center">
                        <button
                          onClick={() => toggleActive(product)}
                          className={`px-3 py-1 rounded-full font-label-sm text-xs ${
                            product.isActive
                              ? 'bg-secondary/10 text-secondary'
                              : 'bg-error/10 text-error'
                          }`}
                        >
                          {product.isActive ? 'Aktif' : 'Nonaktif'}
                        </button>
                      </td>
                      <td className="p-4">
                        <div className="flex justify-center gap-2">
                          <Link
                            href={`/seller/products/${product.id}/edit`}
                            className="text-primary hover:text-primary/70"
                          >
                            <span className="material-icons text-sm">edit</span>
                          </Link>
                          <button
                            onClick={() => deleteProduct(product.id)}
                            className="text-error hover:text-error/70"
                          >
                            <span className="material-icons text-sm">delete</span>
                          </button>
                        </div>
                      </td>
                    </tr>
                  ))}
                </tbody>
              </table>
            </div>
          )}
        </div>
      </main>
      <Footer />
    </>
  );
}
