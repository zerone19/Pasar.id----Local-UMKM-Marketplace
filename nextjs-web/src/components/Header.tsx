import { useState } from 'react';
import Link from 'next/link';

export default function Header() {
  const [menuOpen, setMenuOpen] = useState(false);

  return (
    <header className="bg-primary text-white shadow-lg">
      <nav className="container mx-auto px-4 py-4 flex items-center justify-between">
        <Link href="/" className="text-2xl font-bold font-[Be_Vietnam_Pro]">
          Pasar.ID
        </Link>
        <div className="hidden md:flex gap-6 items-center">
          <Link href="/products" className="hover:text-green-200 transition">Produk</Link>
          <Link href="/stores" className="hover:text-green-200 transition">Toko</Link>
          <Link href="/cart" className="hover:text-green-200 transition">Keranjang</Link>
          <button className="bg-secondary px-4 py-2 rounded hover:bg-green-600 transition">
            Masuk
          </button>
        </div>
        <button className="md:hidden text-2xl" onClick={() => setMenuOpen(!menuOpen)}>
          ☰
        </button>
      </nav>
      {menuOpen && (
        <div className="md:hidden bg-primary px-4 pb-4 space-y-2">
          <Link href="/products" className="block hover:text-green-200">Produk</Link>
          <Link href="/stores" className="block hover:text-green-200">Toko</Link>
          <Link href="/cart" className="block hover:text-green-200">Keranjang</Link>
          <button className="bg-secondary px-4 py-2 rounded w-full">Masuk</button>
        </div>
      )}
    </header>
  );
}
