import Link from 'next/link';
import Image from 'next/image';
import Header from '@/components/Header';
import Footer from '@/components/Footer';

const categories = [
  { name: 'Sayur Segar', image: '/stitch/category-vegetables.jpg', href: '/products?category=sayur' },
  { name: 'Jajanan Pasar', image: '/stitch/category-snacks.jpg', href: '/products?category=jajanan' },
  { name: 'Kerajinan Lokal', image: '/stitch/category-crafts.jpg', href: '/products?category=kerajinan' },
  { name: 'Daging & Ikan', image: '/stitch/category-meat.jpg', href: '/products?category=daging' },
];

const featuredStores = [
  { name: 'Bu Ning Buah Segar', location: 'Pasar Beringharjo', image: '/stitch/store-bu-ning.jpg', size: 'large' },
  { name: 'Kriya Anyam Mbah Tarjo', location: 'Bantul', image: '/stitch/store-kriya.jpg', size: 'small' },
  { name: 'Toko Jajanan Ayu', location: 'Pasar Senen', image: '/stitch/store-jajanan.jpg', size: 'small' },
];

export default function Home() {
  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-20">
        <section className="mx-auto max-w-7xl px-5 pb-14 pt-8 md:px-8 md:pt-12">
          <div className="relative isolate grid min-h-[500px] overflow-hidden rounded-2xl bg-primary shadow-organic lg:grid-cols-[0.9fr_1.1fr]">
            <div className="relative z-10 flex flex-col justify-center p-8 md:p-12 lg:p-16">
              <span className="mb-5 inline-flex w-fit rounded-full border border-white/20 bg-white/10 px-3 py-1 font-label-sm text-white/80">
                Pasar lokal, lebih dekat
              </span>
              <h1 className="max-w-xl font-headline-xl text-4xl leading-[1.08] tracking-tight text-white md:text-6xl">
                Dari pasar lokal, sampai ke pintu Anda.
              </h1>
              <p className="mt-6 max-w-lg font-body-lg text-base leading-7 text-white/80 md:text-lg">
                Temukan bahan segar, jajanan pasar, dan karya tangan dari penjual lokal yang Anda percaya.
              </p>
              <Link href="/products" className="mt-8 inline-flex w-fit items-center gap-3 rounded-lg bg-[#bfef73] px-6 py-3 font-label-md text-[#173b14] transition-transform hover:-translate-y-0.5 active:scale-[0.98]">
                Mulai Belanja <span aria-hidden="true" className="text-lg">↗</span>
              </Link>
            </div>
            <div className="relative min-h-[280px] overflow-hidden lg:min-h-full">
              <Image src="/stitch/hero-market.jpg" alt="Suasana pasar tradisional Indonesia" fill priority sizes="(max-width: 1024px) 100vw, 55vw" className="object-cover" />
              <div className="absolute inset-0 bg-gradient-to-r from-primary via-primary/20 to-transparent lg:from-primary/50 lg:via-transparent" />
              <div className="absolute bottom-5 right-5 rounded-lg bg-white/90 px-4 py-3 text-sm text-on-surface shadow-organic backdrop-blur-sm">
                Belanja dari penjual sekitar
              </div>
            </div>
          </div>
        </section>

        <section className="mx-auto max-w-7xl px-5 py-10 md:px-8">
          <div className="mb-7 flex items-end justify-between gap-4">
            <div>
              <h2 className="font-headline-md text-3xl text-primary">Kategori pilihan</h2>
              <p className="mt-2 font-body-sm text-on-surface-variant">Jelajahi kebutuhan harian Anda</p>
            </div>
            <Link href="/products" className="hidden font-label-md text-primary hover:underline sm:block">Lihat semua produk →</Link>
          </div>
          <div className="grid grid-cols-2 gap-4 md:grid-cols-4 md:gap-6">
            {categories.map((category) => (
              <Link key={category.name} href={category.href} className="group overflow-hidden rounded-xl border border-outline-variant bg-white transition-colors hover:border-primary">
                <div className="relative aspect-[1.15] overflow-hidden bg-surface-container-high">
                  <Image src={category.image} alt={category.name} fill sizes="(max-width: 768px) 50vw, 25vw" className="object-cover transition-transform duration-500 group-hover:scale-105" />
                </div>
                <div className="flex items-center justify-between px-4 py-4">
                  <span className="font-label-md text-on-surface">{category.name}</span>
                  <span aria-hidden="true" className="text-primary opacity-0 transition-opacity group-hover:opacity-100">↗</span>
                </div>
              </Link>
            ))}
          </div>
        </section>

        <section className="mx-auto max-w-7xl px-5 py-12 md:px-8">
          <div className="mb-7">
            <h2 className="font-headline-md text-3xl text-primary">UMKM unggulan</h2>
            <p className="mt-2 font-body-sm text-on-surface-variant">Dukung penggerak ekonomi di sekitar Anda</p>
          </div>
          <div className="grid gap-5 lg:grid-cols-[1.45fr_0.8fr]">
            <StoreCard store={featuredStores[0]} large />
            <div className="grid gap-5 sm:grid-cols-2 lg:grid-cols-1">
              <StoreCard store={featuredStores[1]} />
              <StoreCard store={featuredStores[2]} />
            </div>
          </div>
        </section>
      </main>
      <Footer />
    </>
  );
}

function StoreCard({ store, large = false }: { store: typeof featuredStores[number]; large?: boolean }) {
  return (
    <Link href="/stores" className={`group relative block overflow-hidden rounded-xl bg-primary ${large ? 'min-h-[420px]' : 'min-h-[200px]'}`}>
      <Image src={store.image} alt={store.name} fill sizes={large ? '(max-width: 1024px) 100vw, 65vw' : '(max-width: 1024px) 50vw, 35vw'} className="object-cover transition-transform duration-700 group-hover:scale-105" />
      <div className="absolute inset-0 bg-gradient-to-t from-black/80 via-black/10 to-transparent" />
      <div className="absolute inset-x-0 bottom-0 p-5 text-white md:p-6">
        <p className="mb-2 text-xs font-medium uppercase tracking-[0.16em] text-white/70">UMKM lokal</p>
        <h3 className={`${large ? 'text-2xl md:text-3xl' : 'text-xl'} font-headline-md`}>{store.name}</h3>
        <p className="mt-1 text-sm text-white/75">{store.location}</p>
      </div>
    </Link>
  );
}
