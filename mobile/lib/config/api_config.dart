/// Runtime API configuration for the Pasar.ID backend.
///
/// Android emulators reach a host machine through 10.0.2.2. Override this
/// value with `--dart-define=API_BASE_URL=https://example.test` for a device
/// or deployed environment; no credentials are stored in the app.
class ApiConfig {
  static const baseUrl = String.fromEnvironment(
    'API_BASE_URL',
    defaultValue: 'http://10.0.2.2:3000',
  );

  const ApiConfig._();
}
