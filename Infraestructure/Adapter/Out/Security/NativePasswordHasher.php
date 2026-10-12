<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\Out\Security;
use App\Ports\Out\PasswordHasherInterface;

final class NativePasswordHasher implements PasswordHasherInterface
{
    public function __construct(
        private string|int|null $algo = PASSWORD_DEFAULT,
        private array $options = []
    ) {}

    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, $this->algo, $this->options);
    }

    public function verify(string $plainPassword, string $hashedPassword): bool
    {
        return password_verify($plainPassword, $hashedPassword);
    }
}
