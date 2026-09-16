export default function Home() {
  return (
    <div className="text-center py-20">
      <h1 className="text-4xl font-bold text-primary mb-4 font-[Be_Vietnam_Pro]">
        Selamat Datang di Pasar.ID
      </h1>
      <p className="text-lg text-gray-600 mb-8">
        Gotong Royong Memajukan UMKM Indonesia
      </p>
      <a
        href="/products"
        className="inline-block bg-primary text-white px-8 py-3 rounded-lg hover:bg-green-700 transition"
      >
        Lihat Produk
      </a>
    </div>
  );
}
