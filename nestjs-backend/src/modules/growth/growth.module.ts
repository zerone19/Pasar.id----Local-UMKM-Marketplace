import { Module } from '@nestjs/common';
import { PrismaModule } from '../../prisma/prisma.module';
import { GrowthController } from './growth.controller';
import { GrowthService } from './growth.service';

@Module({
  imports: [PrismaModule],
  controllers: [GrowthController],
  providers: [GrowthService],
})
export class GrowthModule {}
