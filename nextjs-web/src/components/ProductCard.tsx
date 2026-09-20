import Link from 'next/link';
import Icon from '@/components/Icon';

export interface ProductCardProduct {
  id: string;
  name: string;
  slug: string;
  price: number;
  images?: string[];
  stock?: number;
  seller?: { fullName?: string };
  store?: { name?: string };
}

export default function ProductCard({ product }: { product: ProductCardProduct }) {
  const image = product.images?.[0];
  return (
    <Link
      href={`/products/${product.slug}`}
      className="group flex min-w-0 flex-col overflow-hidden rounded-2xl border border-outline-variant bg-surface-container-lowest shadow-sm transition hover:-translate-y-0.5 hover:border-primary hover:shadow-organic"
    >
      <div className="relative aspect-square w-full shrink-0 overflow-hidden bg-surface-container-high">
        {image ? (
          <img src={image} alt={product.name} loading="lazy" className="h-full w-full object-cover transition duration-500 group-hover:scale-105" />
        ) : (
          <div className="flex h-full w-full items-center justify-center text-primary/50"><Icon name="image" size={40} /></div>
        )}
        {product.stock === 0 && <span className="absolute left-3 top-3 rounded-full bg-error px-2 py-1 text-xs font-semibold text-white">Habis</span>}
      </div>
      <div className="flex min-h-[142px] flex-1 flex-col p-4">
        <h3 className="line-clamp-2 min-h-[2.75rem] text-sm font-semibold leading-5 text-on-surface transition group-hover:text-primary">{product.name}</h3>
        <p className="mt-2 line-clamp-1 text-xs text-on-surface-variant">{product.store?.name || product.seller?.fullName || 'UMKM lokal'}</p>
        <p className="mt-auto pt-3 text-base font-bold text-primary">Rp {new Intl.NumberFormat('id-ID').format(product.price)}</p>
      </div>
    </Link>
  );
}
