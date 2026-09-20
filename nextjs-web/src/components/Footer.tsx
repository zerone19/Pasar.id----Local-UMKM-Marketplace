import Image from 'next/image';

export default function Footer() {
  return (
    <footer className="bg-surface-container-high full-width py-8 border-t border-outline-variant mt-16">
      <div className="flex flex-col md:flex-row justify-between items-center w-full px-5 md:px-8 max-w-7xl mx-auto gap-6">
        <div className="flex items-center gap-3">
          <Image src="/stitch/logo-mark.jpg" alt="Logo Pasar.ID" width={40} height={40} className="h-10 w-10 rounded-lg object-cover" />
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
  );
}
