'use client';

import axios from 'axios';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

export default function RegisterPage() {
  const [formData, setFormData] = useState({
    email: '',
    password: '',
    fullName: '',
    phone: '',
    role: 'BUYER',
  });
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const [success, setSuccess] = useState<string | null>(null);
  const router = useRouter();

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLSelectElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
  };

  const handleRegister = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      await axios.post(`${apiUrl}/auth/register`, formData);
      setSuccess('Akun berhasil dibuat! Silakan masuk.');
      setTimeout(() => router.push('/auth/login'), 2000);
    } catch (err: any) {
      setError(
        err.response?.data?.message ||
          'Gagal mendaftar. Silakan coba lagi.',
      );
    } finally {
      setLoading(false);
    }
  };

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <div className="max-w-md mx-auto bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-8">
            <div className="text-center mb-8">
              <span className="material-icons text-5xl text-primary mb-4">
                add_circle
              </span>
              <h1 className="font-headline-md text-2xl text-primary mb-2">
                Daftar Pasar.ID
              </h1>
              <p className="font-body-sm text-sm text-on-surface-variant">
                Sudah punya akun?{' '}
                <Link href="/auth/login" className="text-primary hover:text-primary/80 font-semibold">
                  Masuk di sini
                </Link>
              </p>
            </div>

            {error && (
              <div className="mb-4 p-3 bg-error-container/20 text-error rounded-lg font-body-sm">
                {error}
              </div>
            )}

            {success && (
              <div className="mb-4 p-3 bg-secondary-container/20 text-secondary rounded-lg font-body-sm">
                {success}
              </div>
            )}

            <form onSubmit={handleRegister} className="space-y-5">
              <div>
                <label className="block font-label-md text-sm text-on-surface mb-1">
                  Nama Lengkap
                </label>
                <input
                  type="text"
                  name="fullName"
                  value={formData.fullName}
                  onChange={handleChange}
                  placeholder="John Doe"
                  required
                  minLength={3}
                  className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                />
              </div>

              <div>
                <label className="block font-label-md text-sm text-on-surface mb-1">
                  Email
                </label>
                <input
                  type="email"
                  name="email"
                  value={formData.email}
                  onChange={handleChange}
                  placeholder="nama@email.com"
                  required
                  className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                />
              </div>

              <div>
                <label className="block font-label-md text-sm text-on-surface mb-1">
                  Password
                </label>
                <input
                  type="password"
                  name="password"
                  value={formData.password}
                  onChange={handleChange}
                  placeholder="Minimal 6 karakter"
                  required
                  minLength={6}
                  className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                />
              </div>

              <div>
                <label className="block font-label-md text-sm text-on-surface mb-1">
                  No. HP (Opsional)
                </label>
                <input
                  type="tel"
                  name="phone"
                  value={formData.phone}
                  onChange={handleChange}
                  placeholder="08xx-xxxx-xxxx"
                  className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                />
              </div>

              <button
                type="submit"
                disabled={loading}
                className={`w-full bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md transition ${
                  loading
                    ? 'opacity-50 cursor-not-allowed'
                    : 'hover:bg-primary/80'
                }`}
              >
                {loading ? 'Mendaftar...' : 'Daftar Sekarang'}
              </button>
            </form>

            <div className="mt-6 text-center">
              <p className="font-body-sm text-xs text-on-surface-variant">
                Dengan mendaftar, kamu menyetujui syarat dan ketentuan kami.
              </p>
            </div>
          </div>

          <div className="mt-8 text-center">
            <Link
              href="/"
              className="text-on-surface-variant hover:text-primary font-body-sm transition"
            >
              ← Kembali ke Beranda
            </Link>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}
