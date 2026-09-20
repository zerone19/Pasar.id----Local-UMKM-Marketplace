export const DEFAULT_PRODUCT_IMAGE = '/stitch/products/coffee.jpg';

export const PRODUCT_IMAGE_BY_CATEGORY: Record<string, string> = {
  kopi: '/stitch/products/coffee.jpg',
  makanan: '/stitch/products/snacks.jpg',
  jajanan: '/stitch/products/snacks.jpg',
  kerajinan: '/stitch/products/crafts.jpg',
  batik: '/stitch/products/crafts.jpg',
  sayur: '/stitch/products/vegetables.jpg',
  organik: '/stitch/products/vegetables.jpg',
  daging: '/stitch/products/vegetables.jpg',
};

export function getProductImage(categorySlug?: string | null): string {
  return (categorySlug && PRODUCT_IMAGE_BY_CATEGORY[categorySlug]) || DEFAULT_PRODUCT_IMAGE;
}

export function normalizeProductImages(images: unknown, categorySlug?: string | null): string[] {
  const imageList = Array.isArray(images)
    ? images.filter((image): image is string => typeof image === 'string' && image.trim().length > 0)
    : [];
  const validLocalImages = imageList.filter((image) => image.startsWith('/stitch/products/'));
  return validLocalImages.length > 0 ? validLocalImages : [getProductImage(categorySlug)];
}
