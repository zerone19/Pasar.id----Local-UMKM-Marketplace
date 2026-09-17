import { IsString, IsOptional, IsEmail, IsIn } from 'class-validator';
import { Role } from '@prisma/client';

export class CreateUserDto {
  @IsEmail()
  email!: string;

  @IsString()
  passwordHash!: string;

  @IsString()
  fullName!: string;

  @IsOptional()
  @IsIn([Role.ADMIN, Role.SELLER, Role.BUYER])
  role?: Role;

  @IsOptional()
  @IsString()
  phone?: string;
}
