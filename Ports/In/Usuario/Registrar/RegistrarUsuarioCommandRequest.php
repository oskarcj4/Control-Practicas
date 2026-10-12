<?php
declare(strict_types= 1);

namespace App\Ports\In\Usuario\Registrar;

// DTO de Entrada .
final class RegistrarUsuarioCommandRequest{
  public function __construct(
        public string $username,
        public string $nombre,
        public string $apellido,
        public string $email,
        public string $password,
        public string $carnet,
        public ?int $institucion_id = null,
        public ?int $carrera_id = null,
        public ?string $telefono = null,
        public ?string $biografia = null,
  ){}
}
