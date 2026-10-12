<?php
namespace App\Domain\Models;

use InvalidArgumentException;
final class AsignacionRol{
  public int $usuario_id;
  public int $rol_id;
  public function __construct(int $usuario_id, int $rol_id){
    if( $usuario_id <= 0 || $rol_id <= 0){
      throw new InvalidArgumentException("El rol no puede ser negativo o 0.");
    }
    $this->usuario_id = $usuario_id;
    $this->rol_id = $rol_id;
}

  public function usuario_id(): int
  {
    return $this->usuario_id;
  }

  public function rol_id(): int
  {
    return $this->rol_id;
  }
}
