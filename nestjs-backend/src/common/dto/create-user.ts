import { Role } from '@prisma/client';

export class CreateUserDto {
  email!: string;
  passwordHash!: string;
  fullName!: string;
  role?: Role;
  phone?: string;
}
