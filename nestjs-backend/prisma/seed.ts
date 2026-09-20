import { PrismaClient } from '@prisma/client';
import * as bcrypt from 'bcrypt';
import { Role } from '@prisma/client';

const prisma = new PrismaClient();

async function main() {
  console.log('🌱 Seeding Pasar.ID database...');

  // Create admin user
  const adminPassword = await bcrypt.hash('admin123', 10);
  const admin = await prisma.user.upsert({
    where: { email: 'admin@pasar.id' },
    update: {},
    create: {
      email: 'admin@pasar.id',
      passwordHash: adminPassword,
      fullName: 'Administrator',
      role: Role.ADMIN,
    },
  });
  console.log('✅ Admin user:', admin.email);

  // Create sample seller
  const sellerPassword = await bcrypt.hash('seller123', 10);
  const seller = await prisma.user.upsert({
    where: { email: 'seller@pasar.id' },
    update: {},
    create: {
      email: 'seller@pasar.id',
      passwordHash: sellerPassword,
      fullName: 'Budi Penjual',
      role: Role.SELLER,
      phone: '081234567890',
    },
  });
  console.log('✅ Seller user:', seller.email);

  // Create sample buyer
  const buyerPassword = await bcrypt.hash('buyer123', 10);
  const buyer = await prisma.user.upsert({
    where: { email: 'buyer@pasar.id' },
    update: {},
    create: {
      email: 'buyer@pasar.id',
      passwordHash: buyerPassword,
      fullName: 'Sri Pembeli',
      role: Role.BUYER,
      phone: '089876543210',
      address: 'Jl. Contoh No. 123, Jakarta',
    },
  });
  console.log('✅ Buyer user:', buyer.email);

  // Create seller store
  const store = await prisma.store.upsert({
    where: { slug: 'toko-budi' },
    update: {},
    create: {
      name: 'Toko Budi',
      slug: 'toko-budi',
      description: 'Toko kelontong kopi dan barang lokal',
      ownerId: seller.id,
    },
  });
  console.log('✅ Store:', store.name);

  // Create categories
  const categories = await Promise.all([
    prisma.category.upsert({
      where: { slug: 'kopi' },
      update: {},
      create: { name: 'Kopi', slug: 'kopi', description: 'Biji dan bubuk kopi lokal' },
    }),
    prisma.category.upsert({
      where: { slug: 'makanan' },
      update: {},
      create: { name: 'Makanan', slug: 'makanan', description: 'Makanan tradisional dan camilan' },
    }),
    prisma.category.upsert({
      where: { slug: 'kerajinan' },
      update: {},
      create: { name: 'Kerajinan', slug: 'kerajinan', description: 'Barang tangan dan dekorasi' },
    }),
  ]);
  console.log('✅ Categories:', categories.length);

  // Create products
  const products = await Promise.all([
    prisma.product.upsert({
      where: { slug: 'kopi-luwak-sapu' },
      update: {},
      create: {
        name: 'Kopi Luwak Sapu',
        slug: 'kopi-luwak-sapu',
        description: 'Kopi luwak asli dari Sumatra, diproses secara tradisional',
        price: 150000,
        stock: 20,
        images: ['https://picsum.photos/seed/kopi1/400/400'],
        categoryId: categories[0].id,
        sellerId: seller.id,
        storeId: store.id,
        isActive: true,
      },
    }),
    prisma.product.upsert({
      where: { slug: 'kopi-sigilung-ringan' },
      update: {},
      create: {
        name: 'Kopi Sigilung Ringan',
        slug: 'kopi-sigilung-ringan',
        description: 'Kopi Arabika pilihan dari Sulawesi, cita rasa fruity',
        price: 85000,
        stock: 50,
        images: ['https://picsum.photos/seed/kopi2/400/400'],
        categoryId: categories[0].id,
        sellerId: seller.id,
        storeId: store.id,
        isActive: true,
      },
    }),
    prisma.product.upsert({
      where: { slug: 'nastar-lumayan' },
      update: {},
      create: {
        name: 'Nastar Lumayan',
        slug: 'nastar-lumayan',
        description: 'Kue Nastar tepung sagu khas Jakarta, gurih manis',
        price: 25000,
        stock: 100,
        images: ['https://picsum.photos/seed/nastar/400/400'],
        categoryId: categories[1].id,
        sellerId: seller.id,
        storeId: store.id,
        isActive: true,
      },
    }),
    prisma.product.upsert({
      where: { slug: 'kerajinan-basket-bambu' },
      update: {},
      create: {
        name: 'Kerajinan Basket Bambu',
        slug: 'kerajinan-basket-bambu',
        description: 'Basket anyaman bambu eco-friendly, buatan lokal',
        price: 45000,
        stock: 30,
        images: ['https://picsum.photos/seed/basket/400/400'],
        categoryId: categories[2].id,
        sellerId: seller.id,
        storeId: store.id,
        isActive: true,
      },
    }),
  ]);
  console.log('✅ Products:', products.length);

  console.log('\n🎉 Seeding selesai!');
  console.log('\n📋 Credentials:');
  console.log('  Admin  → admin@pasar.id / admin123');
  console.log('  Seller → seller@pasar.id / seller123');
  console.log('  Buyer  → buyer@pasar.id / buyer123');
}

main()
  .catch((e) => {
    console.error('❌ Seed error:', e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
