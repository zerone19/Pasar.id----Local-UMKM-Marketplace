import {
  Body,
  Controller,
  Get,
  Param,
  Post,
  Put,
  Req,
  UseGuards,
} from '@nestjs/common';
import { Request } from 'express';
import { JwtAuthGuard } from '../auth/jwt-auth.guard';
import { RolesGuard } from '../../common/guards/roles.guard';
import { Roles } from '../../common/decorators/roles.decorator';
import { Role } from '@prisma/client';
import { GrowthService } from './growth.service';

@Controller()
@UseGuards(JwtAuthGuard)
export class GrowthController {
  constructor(private readonly growthService: GrowthService) {}

  private userId(req: Request): string {
    const user = req.user as { id?: string; userId?: string };
    return user.id ?? user.userId ?? '';
  }

  @Get('notifications')
  notifications(@Req() req: Request) {
    return this.growthService.listNotifications(this.userId(req));
  }

  @Put('notifications/:id/read')
  readNotification(@Req() req: Request, @Param('id') id: string) {
    return this.growthService.markNotificationRead(this.userId(req), id);
  }

  @Get('products/:productId/reviews')
  reviews(@Param('productId') productId: string) {
    return this.growthService.listReviews(productId);
  }

  @Post('products/:productId/reviews')
  createReview(
    @Req() req: Request,
    @Param('productId') productId: string,
    @Body() body: { rating: number; comment?: string; orderId?: string },
  ) {
    return this.growthService.createReview(this.userId(req), productId, body.rating, body.comment, body.orderId);
  }

  @Post('vouchers/validate')
  @UseGuards(RolesGuard)
  @Roles(Role.BUYER, Role.SELLER, Role.ADMIN)
  validateVoucher(@Body() body: { code: string; subtotal: number }) {
    return this.growthService.validateVoucher(body.code, body.subtotal);
  }

  @Get('analytics/overview')
  @UseGuards(RolesGuard)
  @Roles(Role.ADMIN)
  getAnalytics() {
    return this.growthService.getAnalytics();
  }

  @Get('chat/conversations')
  conversations(@Req() req: Request) {
    return this.growthService.listConversations(this.userId(req));
  }

  @Post('chat/conversations')
  conversation(@Req() req: Request, @Body() body: { sellerId: string }) {
    return this.growthService.getOrCreateConversation(this.userId(req), body.sellerId);
  }

  @Post('chat/conversations/:id/messages')
  message(@Req() req: Request, @Param('id') id: string, @Body() body: { message: string }) {
    return this.growthService.sendMessage(this.userId(req), id, body.message);
  }
}
