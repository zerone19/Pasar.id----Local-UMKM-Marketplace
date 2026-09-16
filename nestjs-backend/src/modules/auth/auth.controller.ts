import { Controller, Post, Body, HttpCode, HttpStatus } from '@nestjs/common';
import { AuthService } from './auth.service';
import { RegisterDto } from '../../common/dto/register';
import { LoginDto } from '../../common/dto/login';

@Controller('auth')
export class AuthController {
  constructor(private readonly authService: AuthService) {}

  @Post('register')
  async register(@Body() dto: RegisterDto) {
    return this.authService.register(dto);
  }

  @Post('login')
  @HttpCode(HttpStatus.OK)
  async login(@Body() dto: LoginDto) {
    return this.authService.login(dto);
  }
}
