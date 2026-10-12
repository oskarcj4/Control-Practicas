<?php
namespace App\Ports\In\Usuario\Editar;

use App\Domain\Models\Usuario;

interface ObtenerUsuarioPorNombreUseCaseInterface{
  public function execute(string $username): Usuario;
}
