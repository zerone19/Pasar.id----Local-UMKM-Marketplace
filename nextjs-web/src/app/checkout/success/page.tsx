'use client';

import { useEffect, useState } from 'react';
import { useRouter, useSearchParams } from 'next/navigation';
import axios from 'axios';
import Header from '@/components/Header';
import Footer from '@/components/Footer';
import Link from 'next/link';

export default function CheckoutSuccessPage() {
  const router = useRouter();
  const searchParams = useSearchParams();
  const orderId = searchParams.get('orderId');

  const apiUrl = process.env.NEXT_PUBLIC_API_URL || 'http://localhost:3000';
  const [order, setOrder] = useState<any>(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState<string | null>(null);

  const formatPrice = (price: number) => {
    return new Intl.NumberFormat('id-ID').format(price);
  };

  useEffect(() => {
    if (!orderId) {
      setError('Order ID tidak ditemukan.');
      setLoading(false);
      return;
    }

    const fetchOrder = async () => {
      try {
        const token = localStorage.getItem('accessToken');
        if (!token) {
          setError('Silakan login untuk melihat detail pesanan.');
          setLoading(false);
          return;
        }

        const response = await axios.get(`${apiUrl}/orders/${orderId}`, {
          headers: {
            Authorization: `Bearer ${token}`,
          },
        });
        setOrder(response.data);
      } catch (err: any) {
        setError(err.response?.data?.message || 'Gagal memuat detail pesanan.');
      } finally {
        setLoading(false);
      }
    };

    fetchOrder();
  }, [orderId]);

  if (loading) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16 flex items-center justify-center">
          <div className="text-center">
            <div className="animate-spin rounded-full h-12 w-12 border-4 border-primary border-t-transparent mx-auto mb-4"></div>
            <p className="font-body-md text-on-surface-variant">Memuat detail pesanan...</p>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (error) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16 flex items-center justify-center">
          <div className="px-5 md:px-8 max-w-md mx-auto text-center">
            <span className="material-icons text-6xl text-error mb-4">error</span>
            <h2 className="font-headline-md text-xl text-on-surface mb-2">Gagal Memuat Pesanan</h2>
            <p className="font-body-sm text-on-surface-variant mb-6">{error}</p>
            <Link
              href="/"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Kembali ke Beranda
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  if (!order) {
    return (
      <>
        <Header />
        <main className="min-h-screen bg-cream pb-16 flex items-center justify-center">
          <div className="px-5 md:px-8 max-w-md mx-auto text-center">
            <span className="material-icons text-6xl text-on-surface-variant mb-4 opacity-30">receipt_long</span>
            <h2 className="font-headline-md text-xl text-on-surface mb-2">Detail Pesanan Tidak Ditemukan</h2>
            <p className="font-body-sm text-on-surface-variant mb-6">Pesanan tidak ditemukan atau Anda tidak memiliki akses.</p>
            <Link
              href="/"
              className="inline-block bg-primary text-on-primary px-6 py-2 rounded-lg font-label-md hover:bg-primary/80 transition"
            >
              Kembali ke Beranda
            </Link>
          </div>
        </main>
        <Footer />
      </>
    );
  }

  const statusLabels: Record<string, { label: string; color: string; icon: string }> = {
    PENDING: { label: 'Menunggu Konfirmasi', color: 'text-warning bg-warning-container/20', icon: 'schedule' },
    CONFIRMED: { label: 'Dikonfirmasi', color: 'text-secondary bg-secondary-container/20', icon: 'check_circle' },
    PROCESSING: { label: 'Diproses', color: 'text-primary bg-primary-container/20', icon: 'settings' },
    READY: { label: 'Siap Kirim', color: 'text-secondary bg-secondary-container/20', icon: 'inventory_2' },
    SHIPPED: { label: 'Dikirim', color: 'text-primary bg-primary-container/20', icon: 'local_shipping' },
    COMPLETED: { label: 'Selesai', color: 'text-green bg-green-container/20', icon: 'task_alt' },
    CANCELLED: { label: 'Dibatalkan', color: 'text-error bg-error-container/20', icon: 'cancel' },
  };

  const statusInfo = statusLabels[order.status] || { label: order.status, color: 'text-on-surface-variant bg-surface-container-high', icon: 'help' };

  return (
    <>
      <Header />
      <main className="min-h-screen bg-cream pb-16">
        <div className="px-5 md:px-8 max-w-7xl mx-auto py-12">
          {/* Success Header */}
          <div className="text-center mb-12">
            <div className="w-20 h-20 bg-secondary-container/20 rounded-full flex items-center justify-center mx-auto mb-4">
              <span className="material-icons text-3xl text-secondary">check_circle</span>
            </div>
            <h1 className="font-headline-lg text-3xl text-primary mb-2">Pesanan Berhasil Dibuat!</h1>
            <p className="font-body-md text-on-surface-variant">Terima kasih telah berbelanja di Pasar.ID</p>
          </div>

          <div className="grid md:grid-cols-3 gap-8">
            {/* Order Details */}
            <div className="md:col-span-2 space-y-6">
              {/* Order Info Card */}
              <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                <div className="flex items-center justify-between mb-4">
                  <h2 className="font-headline-md text-lg text-on-surface">Detail Pesanan</h2>
                  <span className={`px-3 py-1 rounded-full font-label-md text-sm ${statusInfo.color}`}>
                    <span className="material-icons text-xs mr-1">{statusInfo.icon}</span>
                    {statusInfo.label}
                  </span>
                </div>

                <div className="grid md:grid-cols-2 gap-4 text-sm">
                  <div>
                    <p className="font-body-sm text-on-surface-variant">Nomor Pesanan</p>
                    <p className="font-body-md text-on-surface">{order.orderNumber}</p>
                  </div>
                  <div>
                    <p className="font-body-sm text-on-surface-variant">Tanggal Pesanan</p>
                    <p className="font-body-md text-on-surface">{new Date(order.createdAt).toLocaleDateString('id-ID', { dateStyle: 'full' })}</p>
                  </div>
                  <div>
                    <p className="font-body-sm text-on-surface-variant">Metode Pembayaran</p>
                    <p className="font-body-md text-on-surface">{order.paymentMethod === 'COD' ? 'Bayar di Tempat (COD)' : 'Transfer Manual'}</p>
                  </div>
                  <div>
                    <p className="font-body-sm text-on-surface-variant">Status Pembayaran</p>
                    <p className="font-body-md text-on-surface">{order.paymentStatus}</p>
                  </div>
                </div>
              </div>

              {/* Items */}
              <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                <h2 className="font-headline-md text-lg text-on-surface mb-4">Produk yang Dipesan</h2>
                <div className="space-y-4">
                  {order.items?.map((item: any) => (
                    <div key={item.id} className="flex items-center gap-4 bg-surface-container-low rounded-lg p-4">
                      <div className="w-16 h-16 bg-surface-container-high rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                        {item.product?.images?.[0] ? (
                          <img src={item.product.images[0]} alt={item.product.name} className="w-full h-full object-cover" />
                        ) : (
                          <span className="material-icons text-2xl text-on-surface-variant opacity-30">image</span>
                        )}
                      </div>
                      <div className="flex-1 min-w-0">
                        <h4 className="font-body-md text-on-surface line-clamp-1">{item.product?.name || 'Produk'}</h4>
                        <p className="font-body-sm text-xs text-on-surface-variant">
                          {item.product?.store?.name || item.product?.seller?.fullName || 'UMKM'}
                        </p>
                        <p className="font-label-md text-sm text-primary">Rp {formatPrice(Number(item.price))} × {item.quantity}</p>
                      </div>
                      <p className="font-headline-md text-on-surface">Rp {formatPrice(Number(item.price) * item.quantity)}</p>
                    </div>
                  ))}
                </div>
              </div>

              {/* Shipping Address */}
              <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6">
                <h2 className="font-headline-md text-lg text-on-surface mb-4">Alamat Pengiriman</h2>
                <p className="font-body-sm text-on-surface-variant whitespace-pre-line">{order.shippingAddress}</p>
              </div>

              {/* Notes for COD/Transfer */}
              {order.paymentMethod === 'TRANSFER' && (
                <div className="bg-secondary-container/10 border border-secondary/30 rounded-xl p-6">
                  <h3 className="font-headline-md text-secondary mb-2 flex items-center gap-2">
                    <span className="material-icons">payment</span>
                    Instruksi Transfer
                  </h3>
                  <div className="space-y-2 font-body-sm text-on-surface-variant">
                    <p>Silakan transfer ke rekening berikut:</p>
                    <div className="bg-surface-container-low rounded-lg p-3 font-mono text-sm">
                      <p>Bank: BCA</p>
                      <p>No. Rek: 1234567890</p>
                      <p>Atas Nama: PT Pasar.ID Indonesia</p>
                    </div>
                    <p>Jumlah: <strong className="text-secondary">Rp {formatPrice(Number(order.totalAmount))}</strong></p>
                    <p>Setelah transfer, kirim bukti transfer ke WhatsApp kami: <a href="https://wa.me/6281234567890" className="text-primary hover:underline" target="_blank" rel="noopener noreferrer">0812-3456-7890</a></p>
                    <p className="text-xs text-on-surface-variant/70">Pesanan akan diproses setelah pembayaran dikonfirmasi.</p>
                  </div>
                </div>
              )}

              {order.paymentMethod === 'COD' && (
                <div className="bg-primary-container/10 border border-primary/30 rounded-xl p-6">
                  <h3 className="font-headline-md text-primary mb-2 flex items-center gap-2">
                    <span className="material-icons">local_shipping</span>
                    Bayar di Tempat (COD)
                  </h3>
                  <p className="font-body-sm text-on-surface-variant">
                    Siapkan uang tunai sejumlah <strong className="text-primary">Rp {formatPrice(Number(order.totalAmount))}</strong> saat kurir mengantarkan barang.
                    Pastikan Anda memeriksa barang sebelum membayar.
                  </p>
                </div>
              )}
            </div>

            {/* Sidebar - Payment Summary */}
            <div className="md:col-span-1">
              <div className="bg-surface-container-lowest border border-outline-variant rounded-xl shadow-sm p-6 sticky top-24">
                <h3 className="font-headline-md text-lg text-on-surface mb-4">Ringkasan Pembayaran</h3>
                <div className="space-y-3 mb-4">
                  {order.items?.map((item: any) => (
                    <div key={item.id} className="flex justify-between font-body-sm text-on-surface-variant">
                      <span className="line-clamp-1 pr-2">{item.product?.name || 'Produk'} × {item.quantity}</span>
                      <span>Rp {formatPrice(Number(item.price) * item.quantity)}</span>
                    </div>
                  ))}
                </div>
                <div className="border-t border-outline-variant pt-4 space-y-2">
                  <div className="flex justify-between font-body-sm text-on-surface-variant">
                    <span>Subtotal</span>
                    <span>Rp {formatPrice(Number(order.totalAmount))}</span>
                  </div>
                  <div className="flex justify-between font-body-sm text-on-surface-variant">
                    <span>Ongkir</span>
                    <span className="text-secondary">Gratis</span>
                  </div>
                  <div className="flex justify-between font-headline-md text-lg text-primary border-t border-outline-variant pt-2">
                    <span>Total</span>
                    <span>Rp {formatPrice(Number(order.totalAmount))}</span>
                  </div>
                </div>
                <div className="mt-6 flex flex-col gap-3">
                  <Link
                    href={`/orders/${order.id}`}
                    className="w-full bg-primary text-on-primary py-2 px-4 rounded-lg font-label-md text-center transition hover:bg-primary/80"
                  >
                    Lihat Detail Pesanan
                  </Link>
                  <Link
                    href="/products"
                    className="w-full border border-outline-variant text-on-surface py-2 px-4 rounded-lg font-label-md text-center transition hover:bg-surface-container-high"
                  >
                    Lanjut Belanja
                  </Link>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
      <Footer />
    </>
  );
}