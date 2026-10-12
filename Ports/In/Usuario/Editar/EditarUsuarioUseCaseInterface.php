<?php
namespace App\Ports\In\Usuario\Editar;

use App\Domain\Models\Usuario;

interface EditarUsuarioUseCaseInterface{
  public function execute(EditarCommandRequest $username): Usuario;
}
