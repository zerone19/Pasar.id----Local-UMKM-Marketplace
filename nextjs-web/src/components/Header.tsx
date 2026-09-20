'use client';

import Link from 'next/link';
import { useRouter } from 'next/navigation';
import { useState, useEffect } from 'react';
import { useCart } from '@/contexts/CartContext';
import { clearToken, getUser, getUserRole } from '@/lib/auth';

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);
  const [userRole, setUserRole] = useState<string | null>(null);
  const [userName, setUserName] = useState<string | null>(null);
  const [search, setSearch] = useState('');
  const router = useRouter();
  const { itemCount } = useCart();

  useEffect(() => {
    setUserRole(getUserRole());
    setUserName(getUser()?.fullName || null);
  }, []);

  return (
    <nav className="bg-surface full-width top-0 z-50 border-b border-outline-variant sticky transition-all duration-300">
      <div className="flex justify-between items-center w-full px-5 md:px-8 py-4 max-w-7xl mx-auto">
        {/* Brand */}
        <Link href="/" className="flex items-center gap-3">
          <div className="bg-primary rounded-full p-2">
            <span className="material-icons text-white text-2xl">shopping_cart</span>
          </div>
          <span className="font-headline-lg text-xl text-primary tracking-tight hidden md:block">
            Pasar.ID
          </span>
        </Link>

        {/* Navigation Links (Desktop) */}
        <ul className="hidden md:flex items-center gap-6">
          <li>
            <Link href="/" className="text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md">
              Beranda
            </Link>
          </li>
          <li>
            <Link
              href="/products"
              className="text-primary font-bold border-b-2 border-primary pb-1 text-label-md font-label-md"
            >
              Produk
            </Link>
          </li>
          <li>
            <Link
              href="/stores"
              className="text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md"
            >
              UMKM
            </Link>
          </li>
          <li>
            <Link
              href="/about"
              className="text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md"
            >
              Tentang Kami
            </Link>
          </li>
          {(userRole === 'SELLER' || userRole === 'ADMIN') && (
            <li>
              <Link
                href="/seller"
                className="text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md"
              >
                Seller Dashboard
              </Link>
            </li>
          )}
        </ul>

        {/* Trailing Icons / Actions */}
        <div className="flex items-center gap-3">
          {/* Search Bar */}
          <div className="relative hidden md:block">
            <input
              className="pl-10 pr-4 py-2 rounded-full border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary text-body-sm font-body-sm text-on-surface w-64 placeholder-on-surface-variant"
              placeholder="Cari produk lokal..."
              type="text"
              value={search}
              onChange={(e) => setSearch(e.target.value)}
              onKeyDown={(e) => {
                if (e.key === 'Enter' && search.trim()) {
                  router.push(`/products?search=${encodeURIComponent(search.trim())}`);
                }
              }}
            />
            <span className="material-icons-outlined absolute left-3 top-2.5 text-on-surface-variant">
              search
            </span>
          </div>

          <button
            aria-label="Location"
            className="p-2 text-on-surface-variant hover:bg-surface-container-low transition-all rounded-full"
          >
            <span className="material-icons">location_on</span>
          </button>

          <Link
            href="/cart"
            aria-label="Shopping Basket"
            className="p-2 text-on-surface-variant hover:bg-surface-container-low transition-all rounded-full relative"
          >
            <span className="material-icons">shopping_basket</span>
            {itemCount > 0 && (
              <span className="absolute top-1 right-1 bg-error text-on-error text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">
                {itemCount}
              </span>
            )}
          </Link>

          {userName ? (
            <button
              type="button"
              aria-label="Logout"
              onClick={() => { clearToken(); setUserName(null); setUserRole(null); router.push('/'); }}
              className="hidden md:flex items-center gap-1 text-sm text-primary"
            >
              <span className="material-icons">account_circle</span>
              <span className="max-w-24 truncate">{userName}</span>
            </button>
          ) : (
            <Link
              href="/auth/login"
              aria-label="Account"
              className="p-2 text-on-surface-variant hover:bg-surface-container-low transition-all rounded-full hidden md:flex"
            >
              <span className="material-icons">account_circle</span>
            </Link>
          )}

          {/* Mobile Menu Toggle */}
          <button
            aria-label="Menu"
            className="md:hidden p-2 text-on-surface-variant"
            onClick={() => setMenuOpen(!menuOpen)}
          >
            <span className="material-icons">menu</span>
          </button>
        </div>
      </div>

      {/* Mobile Menu Drawer */}
      {menuOpen && (
        <div className="md:hidden bg-surface-container-low border-t border-outline-variant px-4 pb-4 space-y-2">
          <Link
            href="/"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Beranda
          </Link>
          <Link
            href="/products"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Produk
          </Link>
          <Link
            href="/stores"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            UMKM
          </Link>
          <Link
            href="/about"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Tentang Kami
          </Link>
          <Link
            href="/orders"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Pesanan Saya
          </Link>
          {(userRole === 'SELLER' || userRole === 'ADMIN') && (
            <Link
              href="/seller"
              className="block text-on-surface-variant hover:text-primary transition-colors py-2"
            >
              Seller Dashboard
            </Link>
          )}
        </div>
      )}
    </nav>
  );
}
