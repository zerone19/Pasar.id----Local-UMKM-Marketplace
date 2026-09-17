export default function Footer() {
  return (
    <footer className="bg-surface-container-high full-width py-8 border-t border-outline-variant mt-16">
      <div className="flex flex-col md:flex-row justify-between items-center w-full px-5 md:px-8 max-w-7xl mx-auto gap-6">
        <div className="flex items-center gap-3">
          <div className="bg-primary rounded-full p-2">
            <span className="material-icons text-white text-xl">shopping_cart</span>
          </div>
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
