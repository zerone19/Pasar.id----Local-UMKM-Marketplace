import { PrismaClient, Role } from "@prisma/client";

const prisma = new PrismaClient();

async function main() {
  // Create demo admin user
  const admin = await prisma.user.upsert({
    where: { email: "admin@pasarid.local" },
    update: {},
    create: {
      email: "admin@pasarid.local",
      passwordHash: "$2a$10$placeholder_replace_with_bcrypt_in_production",
      fullName: "Admin Pasar.ID",
      role: Role.ADMIN,
      phone: "081234567890",
    },
  });

  // Create demo seller
  const seller = await prisma.user.upsert({
    where: { email: "seller@pasarid.local" },
    update: {},
    create: {
      email: "seller@pasarid.local",
      passwordHash: "$2a$10$placeholder_replace_with_bcrypt_in_production",
      fullName: "Seller UMKM",
      role: Role.SELLER,
      phone: "081234567891",
    },
  });

  // Create demo store
  await prisma.store.upsert({
    where: { slug: "demo-umkm" },
    update: {},
    create: {
      name: "Demo UMKM Store",
      slug: "demo-umkm",
      description: "Toko contoh untuk demo Pasar.ID",
      ownerId: seller.id,
    },
  });

  // Create demo categories
  const categories = ["Makanan", "Kerajinan", "Pakaian", "Elektronik", "Tanaman"];
  for (const cat of categories) {
    await prisma.category.upsert({
      where: { name: cat },
      update: {},
      create: { name: cat, slug: cat.toLowerCase() },
    });
  }

  console.log("✅ Seed selesai!");
}

main()
  .catch((e) => {
    console.error(e);
    process.exit(1);
  })
  .finally(async () => {
    await prisma.$disconnect();
  });
