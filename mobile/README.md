# Pasar.ID mobile

Minimal Flutter customer app scaffold for the existing Pasar.ID REST API.

## Scope

The app currently displays the public product catalog. Its API client is prepared for:

- `GET /products` and `GET /products/:id`
- `GET /categories`
- `POST /auth/login`
- `GET /orders/user/:userId` (JWT required)

Login, cart, product detail, and order-history screens are not implemented yet; they remain the next mobile slice.

The API routes were matched to `nestjs-backend` and the shared product/user/order shapes in `shared-types/index.ts`. No credentials or tokens are committed.

## Run

1. Start the backend from `nestjs-backend` so it listens on port `3000`.
2. Install Flutter dependencies and run the app:

```bash
flutter pub get
flutter run
```

For an Android emulator, the default API URL is `http://10.0.2.2:3000`. For a physical device or another environment, pass an API base URL at runtime:

```bash
flutter run --dart-define=API_BASE_URL=http://YOUR_COMPUTER_IP:3000
```

Do not use `localhost` from a physical device unless the API runs on that device.

## Verification

Run the standard Flutter checks from this directory:

```bash
flutter analyze
flutter test
```

Flutter/Dart was not available in the implementation environment, so those commands could not be executed here. The files use conventional Flutter/Dart project structure and dependencies.
