'use client';

import axios from 'axios';
import { useState } from 'react';
import { useRouter } from 'next/navigation';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

export default function LoginPage() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);
  const router = useRouter();

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';

  const handleLogin = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);
    try {
      const response = await axios.post(
        `${apiUrl}/auth/login`,
        { email, password },
      );
      const { accessToken, user } = response.data;
      localStorage.setItem('token', accessToken);
      localStorage.setItem('user', JSON.stringify(user));
      // Jika butuh redirect ke halaman sebelumnya atau ke /
      const redirectTo = (new URLSearchParams(window.location.search)).get('redirect') || '/';
      router.push(redirectTo);
    } catch (err: any) {
      setError(err.response?.data?.message || 'Email atau password salah.');
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
                account_circle
              </span>
              <h1 className="font-headline-md text-2xl text-primary mb-2">
                Masuk ke Pasar.ID
              </h1>
              <p className="font-body-sm text-sm text-on-surface-variant">
                Belum punya akun?{' '}
                <Link href="/auth/register" className="text-primary hover:text-primary/80 font-semibold">
                  Daftar di sini
                </Link>
              </p>
            </div>

            {error && (
              <div className="mb-4 p-3 bg-error-container/20 text-error rounded-lg font-body-sm">
                {error}
              </div>
            )}

            <form onSubmit={handleLogin} className="space-y-5">
              <div>
                <label className="block font-label-md text-sm text-on-surface mb-1">
                  Email
                </label>
                <input
                  type="email"
                  value={email}
                  onChange={(e) => setEmail(e.target.value)}
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
                  value={password}
                  onChange={(e) => setPassword(e.target.value)}
                  placeholder="Masukkan password"
                  required
                  minLength={6}
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
                {loading ? 'Masuk...' : 'Masuk'}
              </button>
            </form>

            <div className="mt-6 text-center">
              <p className="font-body-sm text-xs text-on-surface-variant">
                Dengan masuk, kamu menyetujui syarat dan ketentuan kami.
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
