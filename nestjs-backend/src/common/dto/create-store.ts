import { IsString, IsOptional } from 'class-validator';

export class CreateStoreDto {
  @IsString()
  name!: string;

  @IsString()
  slug!: string;

  @IsOptional()
  @IsString()
  description?: string;

  @IsString()
  ownerId!: string;
}
