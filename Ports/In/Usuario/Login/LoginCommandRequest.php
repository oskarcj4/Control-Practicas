<?php
declare(strict_types=1);

namespace App\Ports\In\Usuario\Login;

final class LoginCommandRequest
{
    public function __construct(
        public string $identifier,  // Para que se pueda usar username o mail.
        public string $password,
        public ?string $userAgent = null,
        public ?string $direccion_ip = null
    ) {}
}
