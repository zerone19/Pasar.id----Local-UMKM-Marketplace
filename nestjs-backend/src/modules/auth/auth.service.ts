import { Injectable, UnauthorizedException } from '@nestjs/common';
import { JwtService } from '@nestjs/jwt';
import { UsersService } from '../users/users.service';
import { RegisterDto } from '../../common/dto/register';
import { LoginDto } from '../../common/dto/login';
import * as bcrypt from 'bcrypt';
import { Role } from '@prisma/client';
import { ConfigService } from '@nestjs/config';

@Injectable()
export class AuthService {
  constructor(
    private readonly usersService: UsersService,
    private readonly jwtService: JwtService,
    private readonly configService: ConfigService,
  ) {}

  async register(dto: RegisterDto) {
    const hashedPassword = await bcrypt.hash(dto.password, 10);
    const user = await this.usersService.create({
      email: dto.email,
      passwordHash: hashedPassword,
      fullName: dto.fullName,
      role: Role.BUYER,
      phone: dto.phone,
    });
    const { passwordHash, ...result } = user;
    return { user: result, message: 'Register berhasil' };
  }

  async login(dto: LoginDto) {
    const user = await this.usersService.findByEmail(dto.email);
    if (!user) throw new UnauthorizedException('Email atau password salah');
    const isValid = await bcrypt.compare(dto.password, user.passwordHash);
    if (!isValid) throw new UnauthorizedException('Email atau password salah');
    const payload = { userId: user.id, email: user.email, role: user.role };
    const accessToken = this.jwtService.sign(payload);
    return { accessToken, user: { id: user.id, email: user.email, fullName: user.fullName, role: user.role } };
  }
}
