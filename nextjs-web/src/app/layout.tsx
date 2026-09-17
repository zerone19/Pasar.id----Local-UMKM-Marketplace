import './globals.css';
import type { ReactNode } from 'react';

export const metadata = {
  title: {
    default: 'Pasar.ID — Marketplace UMKM Lokal',
    template: `%s | Pasar.ID`,
  },
  description: 'Pasar.ID — Gotong Royong Memajukan UMKM Indonesia. Marketplace lokal untuk para pedagang dan pembeli.',
  keywords: ['UMKM', 'marketplace', 'lokal', 'pasar', 'indonesia'],
  authors: [{ name: 'Ascjul Zerone' }],
};

export default function RootLayout({
  children,
}: {
  children: ReactNode;
}) {
  return (
    <html lang="id">
      <body className="bg-background text-on-background font-sans antialiased">
        {children}
      </body>
    </html>
  );
}
