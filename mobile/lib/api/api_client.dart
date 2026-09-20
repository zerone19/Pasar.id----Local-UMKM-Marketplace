import 'dart:convert';

import 'package:http/http.dart' as http;

import '../config/api_config.dart';

class ApiException implements Exception {
  const ApiException(this.statusCode, this.message);

  final int statusCode;
  final String message;

  @override
  String toString() => 'ApiException($statusCode): $message';
}

/// Small unauthenticated/authenticated client for the customer-facing routes.
class ApiClient {
  ApiClient({http.Client? client, this.baseUrl = ApiConfig.baseUrl})
      : _client = client ?? http.Client();

  final http.Client _client;
  final String baseUrl;
  String? accessToken;

  Uri _uri(String path, [Map<String, String>? query]) {
    final root = Uri.parse(baseUrl);
    return root.replace(
      path: '${root.path.replaceFirst(RegExp(r'/$'), '')}/$path',
      queryParameters: query,
    );
  }

  Map<String, String> get _headers => {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
        if (accessToken != null) 'Authorization': 'Bearer $accessToken',
      };

  Future<dynamic> _request(String method, String path,
      {Map<String, String>? query, Object? body}) async {
    final request = http.Request(method, _uri(path, query))
      ..headers.addAll(_headers);
    if (body != null) request.body = jsonEncode(body);
    final response = await _client.send(request);
    final text = await response.stream.bytesToString();
    dynamic decoded;
    if (text.isNotEmpty) {
      try {
        decoded = jsonDecode(text);
      } on FormatException {
        decoded = text;
      }
    }
    if (response.statusCode < 200 || response.statusCode >= 300) {
      final message = decoded is Map<String, dynamic>
          ? (decoded['message'] ?? 'Request failed').toString()
          : 'Request failed';
      throw ApiException(response.statusCode, message);
    }
    return decoded;
  }

  Future<Map<String, dynamic>> login(String email, String password) async {
    final result = await _request('POST', 'auth/login', body: {
      'email': email,
      'password': password,
    });
    final data = Map<String, dynamic>.from(result as Map);
    accessToken = data['accessToken'] as String?;
    return data;
  }

  Future<List<dynamic>> categories() async {
    final result = await _request('GET', 'categories');
    return List<dynamic>.from(result as List);
  }

  Future<Map<String, dynamic>> products({String? search, String? category,
      int page = 1, int limit = 20}) async {
    final result = await _request('GET', 'products', query: {
      if (search != null && search.isNotEmpty) 'search': search,
      if (category != null && category.isNotEmpty) 'category': category,
      'page': '$page',
      'limit': '$limit',
    });
    return Map<String, dynamic>.from(result as Map);
  }

  Future<dynamic> product(String id) => _request('GET', 'products/$id');

  Future<List<dynamic>> ordersForUser(String userId) async {
    final result = await _request('GET', 'orders/user/$userId');
    return List<dynamic>.from(result as List);
  }

  void close() => _client.close();
}
