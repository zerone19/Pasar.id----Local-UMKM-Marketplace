import { DynamicModule, Module, Provider } from '@nestjs/common';

export const configProvider: Provider = {
  provide: 'CONFIG',
  useFactory: () => ({
    jwt: {
      secret: process.env.JWT_SECRET || 'fallback_secret',
      expiresIn: process.env.JWT_EXPIRATION || '15m',
      refreshSecret: process.env.JWT_REFRESH_SECRET || 'fallback_refresh',
    },
    database: {
      url: process.env.DATABASE_URL || 'postgresql://plasaid:plasaid_secret_2026@localhost:5432/plasaid_dev',
    },
    redis: {
      url: process.env.REDIS_URL || 'redis://localhost:6379',
    },
  }),
};

@Module({
  providers: [configProvider],
  exports: [configProvider],
})
export class ConfigModule {
  static forRoot(): DynamicModule {
    return {
      module: ConfigModule,
      providers: [configProvider],
      exports: [configProvider],
    };
  }
}
