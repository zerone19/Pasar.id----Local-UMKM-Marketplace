import Header from '@/components/Header';
import Footer from '@/components/Footer';

export default function Home() {
  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        {/* Hero Section */}
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-16">
          <div className="relative rounded-xl overflow-hidden shadow-organic min-h-[400px] flex items-center bg-surface-container-high">
            <div className="absolute inset-0 z-0 bg-primary opacity-20"></div>
            <div className="relative z-10 p-8 md:p-12 max-w-2xl bg-primary/80 backdrop-blur-sm rounded-xl border border-primary-fixed/20 shadow-organic">
              <h1 className="font-headline-xl text-4xl md:text-5xl text-surface-container-lowest mb-6 leading-tight">
                Mendukung UMKM Lokal, Dari Pasar ke Pintu Anda.
              </h1>
              <p className="font-body-lg text-lg text-surface-container-lowest mb-8 max-w-md">
                Temukan kesegaran sayur mayur, kelezatan jajanan pasar, dan keunikan kerajinan tangan dari ribuan penjual lokal terpercaya.
              </p>
              <button className="bg-tertiary text-white font-label-md px-8 py-3 rounded-lg hover:bg-tertiary/80 transition-all flex items-center justify-center gap-2">
                Mulai Belanja
                <span className="material-icons text-sm">arrow_forward</span>
              </button>
            </div>
          </div>
        </section>

        {/* Categories Section */}
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          <div className="flex justify-between items-end mb-6">
            <div>
              <h2 className="font-headline-md text-2xl text-primary mb-1">Kategori Pilihan</h2>
              <p className="font-body-sm text-sm text-on-surface-variant">
                Jelajahi kebutuhan harian Anda
              </p>
            </div>
          </div>
          <div className="grid grid-cols-2 md:grid-cols-4 gap-6">
            {categories.map((cat) => (
              <div
                key={cat.id}
                className="block relative overflow-hidden rounded-lg bg-surface-container-lowest border border-outline-variant shadow-sm hover:border-primary hover:shadow-organic transition-all"
              >
                <div className="h-32 bg-surface-container-high flex items-center justify-center">
                  <span className="material-icons text-4xl text-secondary">{cat.icon}</span>
                </div>
                <div className="p-3 text-center">
                  <span className="font-label-md text-sm text-on-surface">{cat.name}</span>
                </div>
              </div>
            ))}
          </div>
        </section>

        {/* Featured MSME Section */}
        <section className="px-5 md:px-8 max-w-7xl mx-auto py-16">
          <h2 className="font-headline-md text-2xl text-primary mb-1">UMKM Unggulan</h2>
          <p className="font-body-sm text-sm text-on-surface-variant mb-8">
            Dukung penggerak ekonomi sekitar Anda
          </p>

          <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
            {/* Main Feature */}
            <div className="md:col-span-2 relative rounded-xl overflow-hidden group shadow-organic border border-outline-variant">
              <div className="bg-primary/30 h-[400px] flex items-center justify-center">
                <span className="material-icons text-8xl text-primary">store</span>
              </div>
              <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
              <div className="absolute bottom-0 left-0 p-6 w-full">
                <div className="flex items-center gap-2 mb-2">
                  <span className="bg-tertiary text-white font-label-sm px-2 py-1 rounded-sm text-xs">
                    Pilihan Editor
                  </span>
                  <span className="flex items-center text-surface-container-lowest font-label-sm text-xs">
                    <span className="material-icons text-xs mr-1">location_on</span>
                    Pasar Beringharjo
                  </span>
                </div>
                <h3 className="font-headline-md text-xl text-surface-container-lowest">
                  Bu Ning Buah Segar
                </h3>
                <p className="font-body-sm text-sm text-surface-variant mt-1 max-w-md">
                  Menyediakan buah-buahan lokal kualitas terbaik sejak 1995. Langsung dari petani.
                </p>
              </div>
            </div>

            {/* Secondary Features */}
            <div className="flex flex-col gap-6">
              {featuredStores.slice(0, 2).map((store) => (
                <div
                  key={store.id}
                  className="relative rounded-xl overflow-hidden group shadow-sm border border-outline-variant flex-1"
                >
                  <div className="bg-secondary/20 h-48 flex items-center justify-center">
                    <span className="material-icons text-5xl text-secondary">favorite</span>
                  </div>
                  <div className="absolute inset-0 bg-gradient-to-t from-black/70 to-transparent"></div>
                  <div className="absolute bottom-0 left-0 p-4 w-full">
                    <h3 className="font-headline-md text-lg text-surface-container-lowest">
                      {store.name}
                    </h3>
                    <span className="flex items-center text-surface-variant font-label-sm text-xs mt-1">
                      <span className="material-icons text-xs mr-1">location_on</span>
                      {store.location}
                    </span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </>
  );
}

const categories = [
  { id: 1, name: 'Sayur Segar', icon: 'eco' },
  { id: 2, name: 'Jajanan Pasar', icon: 'favorite' },
  { id: 3, name: 'Kerajinan Lokal', icon: 'handcraft' },
  { id: 4, name: 'Daging & Ikan', icon: 'restaurant' },
];

const featuredStores = [
  { id: 1, name: 'Kriya Anyam Mbah Tarjo', location: 'Bantul' },
  { id: 2, name: 'Toko Jajanan Ayu', location: 'Pasar Senen' },
];