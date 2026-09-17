const { PrismaClient } = require('@prisma/client');

const prisma = new PrismaClient();

async function main() {
  // Create sample categories
  const categories = await Promise.all([
    prisma.category.upsert({
      where: { slug: 'sayur-segar' },
      update: {},
      create: { name: 'Sayur Segar', slug: 'sayur-segar', description: 'Sayuran segar lokal' },
    }),
    prisma.category.upsert({
      where: { slug: 'jajanan-pasar' },
      update: {},
      create: { name: 'Jajanan Pasar', slug: 'jajanan-pasar', description: 'Kue dan jajanan tradisional' },
    }),
    prisma.category.upsert({
      where: { slug: 'kerajinan-lokal' },
      update: {},
      create: { name: 'Kerajinan Lokal', slug: 'kerajinan-lokal', description: 'Kerajinan tangan lokal' },
    }),
    prisma.category.upsert({
      where: { slug: 'daging-ikan' },
      update: {},
      create: { name: 'Daging & Ikan', slug: 'daging-ikan', description: 'Daging dan ikan segar' },
    }),
  ]);

  console.log('Seed data created successfully');
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
