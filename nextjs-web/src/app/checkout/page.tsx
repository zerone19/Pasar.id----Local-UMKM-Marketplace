'use client';

import { useState } from 'react';
import { useRouter } from 'next/navigation';
import axios from 'axios';
import { useCart } from '@/contexts/CartContext';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

export default function CheckoutPage() {
  const router = useRouter();
  const { items, itemCount, total, clearCart } = useCart();

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';

  const [step, setStep] = useState<'address' | 'payment' | 'review'>('address');
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState<string | null>(null);

  const [formData, setFormData] = useState({
    fullName: '',
    phone: '',
    address: '',
    city: '',
    province: '',
    postalCode: '',
    paymentMethod: 'COD',
    notes: '',
  });

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('id-ID').format(price);
  };

  const validateStep = () => {
    if (step === 'address') {
      if (!formData.fullName || !formData.phone || !formData.address || !formData.city || !formData.province || !formData.postalCode) {
        setError('Semua field alamat harus diisi.');
        return false;
      }
      setError(null);
      setStep('payment');
    } else if (step === 'payment') {
      setError(null);
      setStep('review');
    }
  };

  const handleSubmit = async (e: React.FormEvent) => {
    e.preventDefault();
    setLoading(true);
    setError(null);

    const token = localStorage.getItem('token');
    if (!token) {
      setError('Silakan login terlebih dahulu untuk melanjutkan checkout.');
      setLoading(false);
      router.push(`/auth/login?redirect=/checkout`);
      return;
    }

    try {
      const shippingAddress = `${formData.fullName}\n${formData.phone}\n${formData.address}, ${formData.city}, ${formData.province} ${formData.postalCode}\n${formData.notes ? `Catatan: ${formData.notes}` : ''}`;

      const response = await axios.post(
        `${apiUrl}/orders`,
        {
          items: items.map((item) => ({
            productId: item.productId,
            quantity: item.quantity,
          })),
          shippingAddress,
          paymentMethod: formData.paymentMethod,
        },
        {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        }
      );

      if (response.data) {
        clearCart();
        router.push(`/checkout/success?orderId=${response.data.id}`);
      }
    } catch (err: any) {
      if (err.response?.status === 401) {
        localStorage.removeItem('token');
        setError('Sesi habis. Silakan login ulang.');
        router.push(`/auth/login?redirect=/checkout`);
      } else {
        setError(err.response?.data?.message || 'Gagal membuat pesanan. Silakan coba lagi.');
      }
    } finally {
      setLoading(false);
    }
  };

  const handleChange = (e: React.ChangeEvent<HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement>) => {
    setFormData({ ...formData, [e.target.name]: e.target.value });
    setError(null);
  };

  if (items.length === 0) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16">
          <div className="px-5 md:px-8 max-w-7xl mx-auto py-16 text-center">
            <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">shopping_basket</span>
            <h2 className="font-headline-md text-xl text-on-surface mb-2">Keranjang kosong</h2>
            <p className="font-body-sm text-on-surface-variant mb-6">Tambahkan produk ke keranjang sebelum checkout.</p>
            <Link
              href="/products"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Belanja Sekarang
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          {/* Progress Steps */}
          <div className="mb-8">
            <div className="flex items-center justify-between">
              {['address', 'payment', 'review'].map((s, i) => (
                <div key={s} className="flex flex-col items-center">
                  <div
                    className={`w-10 h-10 rounded-full flex items-center justify-center font-label-md text-sm transition-all ${
                      ['address', 'payment', 'review'].indexOf(step) >= i
                        ? 'bg-primary text-on-primary'
                        : 'bg-surface-container-high text-on-surface-variant'
                    }`}
                  >
                    {i + 1}
                  </div>
                  <span
                    className={`mt-2 text-xs font-body-sm ${
                      ['address', 'payment', 'review'].indexOf(step) >= i
                        ? 'text-primary'
                        : 'text-on-surface-variant'
                    }`}
                  >
                    {s === 'address' ? 'Alamat' : s === 'payment' ? 'Pembayaran' : 'Review'}
                  </span>
                </div>
              ))}
              <div className="hidden md:flex-1 flex items-center justify-center">
                <div className="w-full h-0.5 bg-outline-variant" />
              </div>
            </div>
          </div>

          {error && (
            <div className="mb-6 p-3 bg-error-container/20 text-error rounded-lg font-body-sm flex items-center gap-2">
              <span className="material-icons text-sm">error</span>
              {error}
            </div>
          )}

          <div className="grid md:grid-cols-3 gap-8">
            {/* Form Section */}
            <div className="md:col-span-2 space-y-6">
              {/* Step 1: Shipping Address */}
              {step === 'address' && (
                <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                  <h2 className="font-headline-md text-lg text-primary mb-4 flex items-center gap-2">
                    <span className="material-icons text-base">local_shipping</span>
                    Alamat Pengiriman
                  </h2>
                  <form onSubmit={(e) => { e.preventDefault(); validateStep(); }} className="space-y-4">
                    <div className="grid md:grid-cols-2 gap-4">
                      <div>
                        <label className="block font-label-md text-sm text-on-surface mb-1">Nama Lengkap *</label>
                        <input
                          type="text"
                          name="fullName"
                          value={formData.fullName}
                          onChange={handleChange}
                          placeholder="John Doe"
                          required
                          className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                        />
                      </div>
                      <div>
                        <label className="block font-label-md text-sm text-on-surface mb-1">No. HP *</label>
                        <input
                          type="tel"
                          name="phone"
                          value={formData.phone}
                          onChange={handleChange}
                          placeholder="08xx-xxxx-xxxx"
                          required
                          className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                        />
                      </div>
                    </div>
                    <div>
                      <label className="block font-label-md text-sm text-on-surface mb-1">Alamat Lengkap *</label>
                      <textarea
                        name="address"
                        value={formData.address}
                        onChange={handleChange}
                        placeholder="Jalan, RT/RW, Kelurahan"
                        required
                        rows={2}
                        className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                      />
                    </div>
                    <div className="grid md:grid-cols-3 gap-4">
                      <div>
                        <label className="block font-label-md text-sm text-on-surface mb-1">Kota *</label>
                        <input
                          type="text"
                          name="city"
                          value={formData.city}
                          onChange={handleChange}
                          placeholder="Jakarta Selatan"
                          required
                          className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                        />
                      </div>
                      <div>
                        <label className="block font-label-md text-sm text-on-surface mb-1">Provinsi *</label>
                        <input
                          type="text"
                          name="province"
                          value={formData.province}
                          onChange={handleChange}
                          placeholder="DKI Jakarta"
                          required
                          className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                        />
                      </div>
                      <div>
                        <label className="block font-label-md text-sm text-on-surface mb-1">Kode Pos *</label>
                        <input
                          type="text"
                          name="postalCode"
                          value={formData.postalCode}
                          onChange={handleChange}
                          placeholder="12345"
                          required
                          className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                        />
                      </div>
                    </div>
                    <div>
                      <label className="block font-label-md text-sm text-on-surface mb-1">Catatan (Opsional)</label>
                      <textarea
                        name="notes"
                        value={formData.notes}
                        onChange={handleChange}
                        placeholder="Contoh: Belakang gedung A, pintu warna biru"
                        rows={2}
                        className="w-full px-4 py-2 border border-outline-variant rounded-lg bg-surface-container-low focus:border-primary focus:ring-1 focus:ring-primary font-body-md text-on-surface placeholder-on-surface-variant/50"
                      />
                    </div>
                    <button
                      type="submit"
                      className="w-full bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md transition hover:bg-primary/80"
                    >
                      Lanjut ke Pembayaran
                    </button>
                  </form>
                </div>
              )}

              {/* Step 2: Payment Method */}
              {step === 'payment' && (
                <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                  <h2 className="font-headline-md text-lg text-primary mb-4 flex items-center gap-2">
                    <span className="material-icons text-base">payment</span>
                    Metode Pembayaran
                  </h2>
                  <form onSubmit={(e) => { e.preventDefault(); validateStep(); }} className="space-y-4">
                    <div className="space-y-3">
                      {['COD', 'TRANSFER'].map((method) => (
                        <label
                          key={method}
                          className={`flex items-center gap-3 p-4 border-2 rounded-lg cursor-pointer transition ${
                            formData.paymentMethod === method
                              ? 'border-primary bg-primary/5'
                              : 'border-outline-variant hover:border-primary/50'
                          }`}
                        >
                          <input
                            type="radio"
                            name="paymentMethod"
                            value={method}
                            checked={formData.paymentMethod === method}
                            onChange={handleChange}
                            className="w-5 h-5 text-primary border-primary focus:ring-primary"
                          />
                          <div className="flex-1">
                            <div className="font-body-md text-on-surface">
                              {method === 'COD' ? 'Bayar di Tempat (COD)' : 'Transfer Manual'}
                            </div>
                            <div className="font-body-sm text-xs text-on-surface-variant mt-1">
                              {method === 'COD'
                                ? 'Bayar saat barang sampai ke tangan Anda.'
                                : 'Transfer ke rekening kami, bukti transfer dikirim via WhatsApp.'}
                            </div>
                          </div>
                        </label>
                      ))}
                    </div>
                    <div className="flex gap-4">
                      <button
                        type="button"
                        onClick={() => { setError(null); setStep('address'); }}
                        className="flex-1 border border-outline-variant text-on-surface py-2 px-4 rounded-lg font-label-md hover:bg-surface-container-high transition"
                      >
                        Kembali
                      </button>
                      <button
                        type="submit"
                        className="flex-1 bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md transition hover:bg-primary/80"
                      >
                        Lanjut ke Review
                      </button>
                    </div>
                  </form>
                </div>
              )}

              {/* Step 3: Review Order */}
              {step === 'review' && (
                <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                  <h2 className="font-headline-md text-lg text-primary mb-4 flex items-center gap-2">
                    <span className="material-icons text-base">receipt_long</span>
                    Review Pesanan
                  </h2>
                  <div className="space-y-3 mb-6 max-h-64 overflow-y-auto pr-2">
                    {items.map((item) => (
                      <div key={item.productId} className="flex items-center gap-3 bg-surface-container-low rounded-lg p-3">
                        <div className="w-16 h-16 bg-surface-container-high rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                          {item.image ? (
                            <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                          ) : (
                            <span className="material-icons text-2xl text-on-surface-variant opacity-30">image</span>
                          )}
                        </div>
                        <div className="flex-1 min-w-0">
                          <h4 className="font-body-md text-on-surface line-clamp-1">{item.name}</h4>
                          <p className="font-body-sm text-xs text-on-surface-variant">{item.storeName}</p>
                          <p className="font-label-md text-sm text-primary">Rp {formatPrice(item.price)} × {item.quantity}</p>
                        </div>
                      </div>
                    ))}
                  </div>

                  <div className="border-t border-outline-variant pt-4 space-y-3 mb-6">
                    <div className="flex justify-between text-on-surface-variant font-body-sm">
                      <span>Subtotal ({itemCount} item)</span>
                      <span>Rp {formatPrice(total)}</span>
                    </div>
                    <div className="flex justify-between text-on-surface-variant font-body-sm">
                      <span>Ongkir</span>
                      <span>Rp 0 (Gratis)</span>
                    </div>
                    <div className="flex justify-between text-primary font-headline-md text-lg border-t border-outline-variant pt-3">
                      <span>Total</span>
                      <span>Rp {formatPrice(total)}</span>
                    </div>
                  </div>

                  <div className="bg-surface-container-low rounded-lg p-4 mb-6">
                    <h4 className="font-label-md text-on-surface mb-2">Alamat Pengiriman</h4>
                    <p className="font-body-sm text-on-surface-variant whitespace-pre-line">
                      {formData.fullName}
                      <br />
                      {formData.phone}
                      <br />
                      {formData.address}, {formData.city}, {formData.province} {formData.postalCode}
                      {formData.notes ? `\nCatatan: ${formData.notes}` : ''}
                    </p>
                  </div>

                  <div className="bg-surface-container-low rounded-lg p-4 mb-6">
                    <h4 className="font-label-md text-on-surface mb-2">Metode Pembayaran</h4>
                    <p className="font-body-sm text-on-surface-variant">
                      {formData.paymentMethod === 'COD' ? 'Bayar di Tempat (COD)' : 'Transfer Manual'}
                    </p>
                  </div>

                  <div className="flex gap-4">
                    <button
                      type="button"
                      onClick={() => { setError(null); setStep('payment'); }}
                      className="flex-1 border border-outline-variant text-on-surface py-2 px-4 rounded-lg font-label-md hover:bg-surface-container-high transition"
                    >
                      Kembali
                    </button>
                    <button
                      type="submit"
                      onClick={handleSubmit}
                      disabled={loading}
                      className="flex-1 bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md transition hover:bg-primary/80 disabled:opacity-50 disabled:cursor-not-allowed"
                    >
                      {loading ? 'Memproses...' : 'Buat Pesanan'}
                    </button>
                  </div>
                </div>
              )}
            </div>

            {/* Order Summary Sidebar */}
            <div className="md:col-span-1">
              <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6 sticky top-24">
                <h3 className="font-headline-md text-lg text-on-surface mb-4">Ringkasan Pesanan</h3>
                <div className="space-y-3 mb-4 max-h-48 overflow-y-auto pr-2">
                  {items.map((item) => (
                    <div key={item.productId} className="flex items-center gap-3">
                      <div className="w-14 h-14 bg-surface-container-high rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                        {item.image ? (
                          <img src={item.image} alt={item.name} className="w-full h-full object-cover" />
                        ) : (
                          <span className="material-icons text-xl text-on-surface-variant opacity-30">image</span>
                        )}
                      </div>
                      <div className="flex-1 min-w-0">
                        <p className="font-body-sm text-on-surface line-clamp-1">{item.name}</p>
                        <p className="font-body-sm text-xs text-on-surface-variant">× {item.quantity}</p>
                      </div>
                      <p className="font-label-md text-sm text-on-surface">Rp {formatPrice(item.price * item.quantity)}</p>
                    </div>
                  ))}
                </div>
                <div className="border-t border-outline-variant pt-4 space-y-2">
                  <div className="flex justify-between font-body-sm text-on-surface-variant">
                    <span>Subtotal</span>
                    <span>Rp {formatPrice(total)}</span>
                  </div>
                  <div className="flex justify-between font-body-sm text-on-surface-variant">
                    <span>Ongkir</span>
                    <span className="text-secondary">Gratis</span>
                  </div>
                  <div className="flex justify-between font-headline-md text-lg text-primary border-t border-outline-variant pt-2">
                    <span>Total</span>
                    <span>Rp {formatPrice(total)}</span>
                  </div>
                </div>
                <p className="mt-4 font-body-sm text-xs text-on-surface-variant text-center">
                  Dengan membuat pesanan, Anda menyetujui <Link href="/terms" className="text-primary hover:underline">Syarat & Ketentuan</Link> kami.
                </p>
              </div>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}