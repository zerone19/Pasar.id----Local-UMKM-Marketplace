import Header from './components/Header';

export default function App({ Component, pageProps }) {
  return (
    <div className="min-h-screen bg-background">
      <Header />
      <main className="container mx-auto px-4 py-8">
        <Component {...pageProps} />
      </main>
    </div>
  );
}
