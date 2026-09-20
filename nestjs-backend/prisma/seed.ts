import { PrismaClient, Role } from '@prisma/client';
import * as bcrypt from 'bcrypt';

const prisma = new PrismaClient();

const stores = [
  ['Toko Budi', 'toko-budi', 'Kopi dan kebutuhan harian pilihan dari penjual lokal.'],
  ['Bu Ning Buah Segar', 'bu-ning-buah-segar', 'Buah dan sayur segar dari pasar lokal.'],
  ['Kriya Anyam Mbah Tarjo', 'kriya-anyam-mbah-tarjo', 'Kerajinan anyaman yang dibuat dengan tangan.'],
  ['Toko Jajanan Ayu', 'toko-jajanan-ayu', 'Jajanan pasar dan camilan rumahan.'],
  ['Dapur Sari Nusantara', 'dapur-sari-nusantara', 'Bumbu dan makanan rumahan khas Indonesia.'],
  ['Batik Lestari Jogja', 'batik-lestari-jogja', 'Batik lokal dengan motif yang bernilai budaya.'],
  ['Laut Segar Bahari', 'laut-segar-bahari', 'Hasil laut segar dari nelayan setempat.'],
  ['Kebun Hidup Organik', 'kebun-hidup-organik', 'Bahan pangan organik dari kebun lokal.'],
] as const;

const productTemplates = [
  ['Produk Pilihan', 25000, 'Produk lokal pilihan dengan kualitas terbaik.'],
  ['Paket Hemat Keluarga', 55000, 'Paket praktis untuk kebutuhan keluarga sehari-hari.'],
  ['Produk Premium Lokal', 95000, 'Pilihan premium dari UMKM terpercaya.'],
  ['Paket Oleh-Oleh', 40000, 'Cocok untuk hadiah dan oleh-oleh khas daerah.'],
] as const;

async function main() {
  console.log('Seeding Pasar.ID demo data...');
  const passwordHash = await bcrypt.hash('demo-password-change-me', 10);
  const admin = await prisma.user.upsert({
    where: { email: 'admin@pasar.id' },
    update: { fullName: 'Administrator', role: Role.ADMIN },
    create: { email: 'admin@pasar.id', passwordHash, fullName: 'Administrator', role: Role.ADMIN },
  });
  await prisma.user.upsert({
    where: { email: 'buyer@pasar.id' },
    update: { fullName: 'Sri Pembeli', role: Role.BUYER },
    create: { email: 'buyer@pasar.id', passwordHash, fullName: 'Sri Pembeli', role: Role.BUYER },
  });

  const categoryData = [
    ['Kopi', 'kopi'], ['Makanan', 'makanan'], ['Kerajinan', 'kerajinan'],
    ['Sayur Segar', 'sayur'], ['Jajanan Pasar', 'jajanan'], ['Batik', 'batik'],
    ['Daging & Ikan', 'daging'], ['Organik', 'organik'],
  ] as const;
  const categories = new Map<string, { id: string }>();
  for (const [name, slug] of categoryData) {
    categories.set(slug, await prisma.category.upsert({
      where: { slug }, update: { name }, create: { name, slug, description: `${name} lokal pilihan` },
    }));
  }

  const productImages = ['/stitch/products/coffee.jpg', '/stitch/products/vegetables.jpg', '/stitch/products/crafts.jpg', '/stitch/products/snacks.jpg'];
  const categoryImageBySlug: Record<string, string> = {
    kopi: productImages[0], makanan: productImages[3], jajanan: productImages[3],
    kerajinan: productImages[2], batik: productImages[2], sayur: productImages[1],
    organik: productImages[1], daging: productImages[1],
  };
  const existingProducts = await prisma.product.findMany({ include: { category: { select: { slug: true } } } });
  for (const product of existingProducts) {
    await prisma.product.update({
      where: { id: product.id },
      data: { images: [categoryImageBySlug[product.category.slug] || productImages[0]], isActive: true },
    });
  }
  let totalProducts = 0;
  for (let storeIndex = 0; storeIndex < stores.length; storeIndex += 1) {
    const [name, slug, description] = stores[storeIndex];
    const seller = await prisma.user.upsert({
      where: { email: `seller${storeIndex + 1}@pasar.id` },
      update: { fullName: `Pemilik ${name}`, role: Role.SELLER },
      create: { email: `seller${storeIndex + 1}@pasar.id`, passwordHash, fullName: `Pemilik ${name}`, role: Role.SELLER },
    });
    const store = await prisma.store.upsert({
      where: { slug }, update: { name, description, ownerId: seller.id },
      create: { name, slug, description, ownerId: seller.id },
    });
    const categorySlugs = ['kopi', 'makanan', 'kerajinan', 'sayur', 'jajanan', 'batik', 'daging', 'organik'];
    for (let productIndex = 0; productIndex < productTemplates.length; productIndex += 1) {
      const [template, basePrice, productDescription] = productTemplates[productIndex];
      const productSlug = `${slug}-${productIndex + 1}`;
      await prisma.product.upsert({
        where: { slug: productSlug },
        update: {
          name: `${template} ${name}`, description: productDescription, price: basePrice + storeIndex * 5000,
          stock: 20 + productIndex * 10, images: [productImages[storeIndex % 4]],
          categoryId: categories.get(categorySlugs[storeIndex])!.id, sellerId: seller.id, storeId: store.id, isActive: true,
        },
        create: {
          name: `${template} ${name}`, slug: productSlug, description: productDescription, price: basePrice + storeIndex * 5000,
          stock: 20 + productIndex * 10, images: [productImages[storeIndex % 4]],
          categoryId: categories.get(categorySlugs[storeIndex])!.id, sellerId: seller.id, storeId: store.id, isActive: true,
        },
      });
      totalProducts += 1;
    }
  }
  console.log(`Seed complete: ${stores.length} stores, ${totalProducts} products, admin ${admin.email}`);
}

main().catch((error) => { console.error('Seed error:', error); process.exit(1); }).finally(() => prisma.$disconnect());
