export default function ProductsPage() {
  return (
    <div>
      <h1 className="text-3xl font-bold text-primary mb-6 font-[Be_Vietnam_Pro]">
        Daftar Produk
      </h1>
      <div className="grid grid-cols-1 md:grid-cols-3 gap-6">
        {/* Produk cards akan di-isi dari API */}
        <div className="bg-white rounded-lg shadow p-6 border border-gray-200">
          <div className="h-48 bg-gray-200 rounded-lg mb-4"></div>
          <h3 className="font-bold text-lg">Produk Example</h3>
          <p className="text-gray-600">Deskripsi produk</p>
          <p className="text-primary font-bold mt-2">Rp 0</p>
        </div>
      </div>
    </div>
  );
}
