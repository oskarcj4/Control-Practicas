<?php
declare(strict_types=1);

namespace App\Ports\Out;


interface TokenManagerInterface{
  public function generateAccessToken(int $user_id, string $username, int $rol_id ): string;
  public function generateRefreshToken(): string;

  public function validateAccessToken(string $token): array;
}
