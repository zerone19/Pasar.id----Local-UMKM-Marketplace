import { NestFactory } from '@nestjs/core';
import { AppModule } from './app.module';
import { ValidationPipe } from '@nestjs/common';
import { Logger } from '@nestjs/common';

async function bootstrap() {
  const app = await NestFactory.create(AppModule);

  app.useGlobalPipes(
    new ValidationPipe({
      whitelist: true,
      transform: true,
      forbidNonWhitelisted: true,
    }),
  );

  app.enableCors({
    origin: 'http://localhost:3001',
    credentials: true,
  });

  const logger = new Logger('Pasar.ID');
  await app.listen(3000);
  logger.log('Pasar.ID API running on http://localhost:3000');
}

bootstrap();
