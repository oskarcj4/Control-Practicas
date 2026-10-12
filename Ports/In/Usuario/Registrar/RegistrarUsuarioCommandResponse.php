<?php
declare(strict_types= 1);

namespace App\Ports\In\Usuario\Registrar;

// DTO de Salida .
final class RegistrarUsuarioCommandResponse{
  public function __construct(
      public string $username,
      public string $email,
      public bool $autorizado_publicar,
      public string $nombre,
      public ?int $institucion_id,
  ){}
}
