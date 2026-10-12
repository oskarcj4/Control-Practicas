<?php
declare(strict_types=1);

namespace App\Ports\In\Usuario\Login;

final class LoginCommandResponse
{
    public function __construct(
        public int $userId,
        public string $username,
        public int $rol_id,
        public string $refreshToken,
        public string $accessToken,
        public int $expiraEn){}
}
