import Link from 'next/link';

interface StoreCardProps {
  id: string;
  name: string;
  slug: string;
  description?: string | null;
  ownerName: string;
  productCount: number;
}

export default function StoreCard({
  id,
  name,
  slug,
  description,
  ownerName,
  productCount,
}: StoreCardProps) {
  return (
    <Link
      href={`/stores/${slug || id}`}
      className="group block bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm hover:shadow-organic hover:border-primary transition-all overflow-hidden"
    >
      <div className="p-5">
        <div className="flex items-start justify-between mb-2">
          <div className="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center flex-shrink-0">
            <span className="material-icons text-primary text-lg">store</span>
          </div>
          <span className="bg-tertiary-container text-on-tertiary text-xs font-label-sm px-2 py-1 rounded-full">
            {productCount} produk
          </span>
        </div>

        <h3 className="font-headline-lg text-lg text-on-surface group-hover:text-primary transition-colors line-clamp-1 mb-1">
          {name}
        </h3>

        {ownerName && (
          <p className="font-body-sm text-xs text-on-surface-variant mb-2">
            oleh {ownerName}
          </p>
        )}

        {description && (
          <p className="font-body-sm text-sm text-on-surface-variant line-clamp-2">
            {description}
          </p>
        )}
      </div>
    </Link>
  );
}
