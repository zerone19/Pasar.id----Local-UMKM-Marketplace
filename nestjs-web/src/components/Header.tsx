'use client';

import Link from 'next/link';
import { useState } from 'react';

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);

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
              Pasar
            </Link>
          </li>
          <li>
            <Link
              href="/categories"
              className="text-primary font-bold border-b-2 border-primary pb-1 text-label-md font-label-md"
            >
              Kategori
            </Link>
          </li>
          <li>
            <Link
              href="/umkm"
              className="text-on-surface-variant hover:text-primary transition-colors text-label-md font-label-md"
            >
              UMKM Terdekat
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
        </ul>

        {/* Trailing Icons / Actions */}
        <div className="flex items-center gap-3">
          {/* Search Bar */}
          <div className="relative hidden md:block">
            <input
              className="pl-10 pr-4 py-2 rounded-full border border-outline-variant bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary text-body-sm font-body-sm text-on-surface w-64 placeholder-on-surface-variant"
              placeholder="Cari produk lokal..."
              type="text"
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

          <button
            aria-label="Shopping Basket"
            className="p-2 text-on-surface-variant hover:bg-surface-container-low transition-all rounded-full relative"
          >
            <span className="material-icons">shopping_basket</span>
            <span className="absolute top-1 right-1 bg-error text-on-error text-[10px] font-bold px-1.5 py-0.5 rounded-full leading-none">
              3
            </span>
          </button>

          <button
            aria-label="Account"
            className="p-2 text-on-surface-variant hover:bg-surface-container-low transition-all rounded-full hidden md:block"
          >
            <span className="material-icons">account_circle</span>
          </button>

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
            Pasar
          </Link>
          <Link
            href="/categories"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Kategori
          </Link>
          <Link
            href="/umkm"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            UMKM Terdekat
          </Link>
          <Link
            href="/about"
            className="block text-on-surface-variant hover:text-primary transition-colors py-2"
          >
            Tentang Kami
          </Link>
        </div>
      )}
    </nav>
  );
}
