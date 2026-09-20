'use client';

import Header from '@/components/Header';
import Footer from '@/components/Footer';

export default function AboutPage() {
  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream py-16">
        <div className="max-w-3xl mx-auto px-5 md:px-8">
          <h1 className="font-headline-md text-3xl text-primary mb-4">Tentang Pasar.ID</h1>
          <p className="font-body-md text-on-surface-variant leading-relaxed">
            Pasar.ID adalah marketplace lokal yang membantu UMKM Indonesia menjangkau
            pelanggan lebih luas melalui ekosistem digital yang sederhana dan terpercaya.
          </p>
          <p className="font-body-md text-on-surface-variant leading-relaxed mt-4">
            Kami membawa semangat gotong royong ke dalam pengalaman belanja, berjualan,
            dan berkembang bersama.
          </p>
        </div>
      </main>
      <Footer />
    </>
  );
}
