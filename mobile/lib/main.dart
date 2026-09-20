import 'package:flutter/material.dart';

import 'api/api_client.dart';

void main() {
  runApp(const PasarIdApp());
}

class PasarIdApp extends StatelessWidget {
  const PasarIdApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp(
      title: 'Pasar.ID',
      debugShowCheckedModeBanner: false,
      theme: ThemeData(
        colorScheme: ColorScheme.fromSeed(seedColor: const Color(0xff167c80)),
        useMaterial3: true,
      ),
      home: const ProductCatalogPage(),
    );
  }
}

class ProductCatalogPage extends StatefulWidget {
  const ProductCatalogPage({super.key});

  @override
  State<ProductCatalogPage> createState() => _ProductCatalogPageState();
}

class _ProductCatalogPageState extends State<ProductCatalogPage> {
  final _api = ApiClient();
  late Future<Map<String, dynamic>> _products;

  @override
  void initState() {
    super.initState();
    _products = _api.products();
  }

  @override
  void dispose() {
    _api.close();
    super.dispose();
  }

  void _reload() => setState(() => _products = _api.products());

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(
        title: const Text('Pasar.ID'),
        actions: [
          IconButton(
            tooltip: 'Refresh products',
            onPressed: _reload,
            icon: const Icon(Icons.refresh),
          ),
        ],
      ),
      body: FutureBuilder<Map<String, dynamic>>(
        future: _products,
        builder: (context, snapshot) {
          if (snapshot.connectionState == ConnectionState.waiting) {
            return const Center(child: CircularProgressIndicator());
          }
          if (snapshot.hasError) {
            return _ErrorState(error: snapshot.error!, onRetry: _reload);
          }
          final rawItems = snapshot.data?['data'];
          final products = rawItems is List ? rawItems : const <dynamic>[];
          if (products.isEmpty) {
            return const Center(child: Text('Belum ada produk tersedia.'));
          }
          return RefreshIndicator(
            onRefresh: () async => _reload(),
            child: ListView.separated(
              padding: const EdgeInsets.all(16),
              itemCount: products.length,
              separatorBuilder: (_, __) => const SizedBox(height: 12),
              itemBuilder: (context, index) => _ProductCard(
                product: Map<String, dynamic>.from(products[index] as Map),
              ),
            ),
          );
        },
      ),
    );
  }
}

class _ProductCard extends StatelessWidget {
  const _ProductCard({required this.product});

  final Map<String, dynamic> product;

  @override
  Widget build(BuildContext context) {
    final price = product['price'];
    final stock = product['stock'];
    return Card(
      child: ListTile(
        contentPadding: const EdgeInsets.all(16),
        leading: const CircleAvatar(child: Icon(Icons.shopping_bag_outlined)),
        title: Text(product['name']?.toString() ?? 'Produk'),
        subtitle: Text('Rp ${price ?? '-'}  •  Stok: ${stock ?? '-'}'),
        isThreeLine: true,
      ),
    );
  }
}

class _ErrorState extends StatelessWidget {
  const _ErrorState({required this.error, required this.onRetry});

  final Object error;
  final VoidCallback onRetry;

  @override
  Widget build(BuildContext context) {
    return Center(
      child: Padding(
        padding: const EdgeInsets.all(24),
        child: Column(
          mainAxisSize: MainAxisSize.min,
          children: [
            const Icon(Icons.cloud_off, size: 48),
            const SizedBox(height: 12),
            const Text('Tidak dapat memuat produk.'),
            const SizedBox(height: 4),
            Text('$error', textAlign: TextAlign.center),
            const SizedBox(height: 16),
            FilledButton(onPressed: onRetry, child: const Text('Coba lagi')),
          ],
        ),
      ),
    );
  }
}
