import Link from 'next/link';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import CategorySection from '@/components/CategorySection';
import FeaturedSection from '@/components/FeaturedSection';
import HeroSection from '@/components/HeroSection';

export default function Home() {
  return (
    <>
      <Header />
      <main className="min-h-screen bg-[#fbf9f4]">
        <HeroSection />
        <CategorySection />
        <FeaturedSection />
      </main>
      <Footer />
    </>
  );
}
