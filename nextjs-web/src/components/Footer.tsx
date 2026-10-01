import Image from 'next/image';
import Link from 'next/link';
import Icon from '@/components/Icon';

type NavLink = { href: string; label: string; icon: 'home' | 'shopping_bag' | 'store' | 'shopping_cart' | 'person' };

const navLinks: NavLink[] = [
  { href: '/', label: 'Beranda', icon: 'home' },
  { href: '/products', label: 'Produk', icon: 'shopping_bag' },
  { href: '/stores', label: 'UMKM', icon: 'store' },
  { href: '/cart', label: 'Keranjang', icon: 'shopping_cart' },
  { href: '/auth/login', label: 'Akun', icon: 'person' },
];

export default function Footer() {
  return (
    <>
      {/* Desktop footer */}
      <footer className="hidden md:block full-width py-8 border-t border-outline-variant mt-16">
        <div className="flex flex-col md:flex-row justify-between items-center w-full px-5 md:px-8 max-w-7xl mx-auto gap-6">
          <div className="flex items-center gap-3">
            <Image
              src="/stitch/logo-mark.jpg"
              alt="Logo Pasar.ID"
              width={40}
              height={40}
              className="h-10 w-10 rounded-lg object-cover"
            />
            <span className="font-headline-md text-xl text-primary">Pasar.ID</span>
          </div>
          <div className="flex flex-wrap justify-center gap-6 font-body-sm text-sm">
            <a href="#" className="text-on-surface-variant hover:text-secondary underline transition-all">Misi Komunitas</a>
            <a href="#" className="text-on-surface-variant hover:text-secondary underline transition-all">Daftar Jadi Penjual</a>
            <a href="#" className="text-on-surface-variant hover:text-secondary underline transition-all">Pusat Bantuan</a>
            <a href="#" className="text-on-surface-variant hover:text-secondary underline transition-all">Syarat & Ketentuan</a>
          </div>
          <div className="font-body-sm text-sm text-on-surface opacity-80 hover:opacity-100 transition-opacity text-center md:text-right">
            © 2024 Pasar.ID - Gotong Royong Memajukan UMKM Indonesia
          </div>
        </div>
      </footer>

      {/* Mobile bottom tab bar (native-app style) */}
      <nav
        aria-label="Navigasi bawah"
        className="fixed inset-x-0 bottom-0 md:hidden bg-surface-container-lowest border-t border-outline-variant shadow-organic z-40"
        style={{ paddingBottom: 'max(env(safe-area-inset-bottom), 1rem)' }}
      >
        <ul className="grid h-16 grid-cols-5 items-center">
          {navLinks.map((link) => (
            <li key={link.href} className="flex justify-center">
              <Link
                href={link.href}
                className="flex flex-col items-center justify-center gap-0.5 py-1 text-on-surface-variant hover:text-primary transition-colors"
              >
                <Icon name={link.icon} size={22} />
                <span className="font-body-sm text-[10px] leading-tight">{link.label}</span>
              </Link>
            </li>
          ))}
        </ul>
      </nav>
    </>
  );
}
