<?php
declare(strict_types=1);

namespace App\Ports\In\Usuario\Editar;

final class EditarCommandRequest
{
    public function __construct(
        public int $usuarioIdTarget,
        public string $username,
        public string $nombre,
        public string $apellido,
        public string $email,
        public string $carnet,
        public ?int $institucion_id = null,
        public ?int $carrera_id = null,
        public ?string $telefono = null,
        public ?string $biografia = null,
        public int $authenticatedUserId,
        public int $authenticatedRolId
    ) {}
}
