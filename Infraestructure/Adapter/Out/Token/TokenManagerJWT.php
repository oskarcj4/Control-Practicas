<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\Out\Token;

use App\Ports\Out\TokenManagerInterface;
use DomainException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Throwable;


final class TokenManagerJWT implements TokenManagerInterface {
    public function __construct(
        private string $secret,
        private int $accessTlsSeconds= 900
      ){}

    public function generateAccessToken(int $user_id, string $username, int $rol_id): string{

      $now = time();

      return (string) JWT::encode([
        'sub'=> $user_id,
        'username' => $username,
        'rol_id' => $rol_id,
        'iat' => $now,
        'exp' => $now + $this->accessTlsSeconds,
      ], $this->secret, 'HS256');

    }

  public function generateRefreshToken(): string
    {
        return bin2hex(random_bytes(32));
    }

    public function validateAccessToken(string $token): array {
      try{
        $decoded = JWT::decode($token, new Key($this->secret, 'HS256'));

        return [
          'user_id' => (int) $decoded->sub,
          'username' => (string) $decoded->username,
          'rol_id' => (int) $decoded->rol_id,
        ];
      }catch(Throwable $e){
        throw new DomainException("Token invalido o expirado" . $e->getMessage(), 0, $e);
      }
    }
}
