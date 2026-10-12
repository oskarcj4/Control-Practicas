<?php
declare(strict_types= 1);
namespace App\Ports\Services;
use App\Domain\Models\Usuario;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorNombreUseCaseInterface;
use App\Ports\Out\UserRepositoryInterface;
use DomainException;


final class ObtenerUsuarioPorNombreUseCaseImpl implements ObtenerUsuarioPorNombreUseCaseInterface{

    public function __construct(
        private UserRepositoryInterface $usuarioRepository
    ) {}
  public function execute(string $username): Usuario{

    if(strlen($username) <= 2){
      throw new DomainException("El nombre de usuario a buscar es muy corto");
    }
    $usuario = $this->usuarioRepository->findByUsername($username);
    if(is_null($usuario)){
      throw new DomainException("El usuario que buscas no existe.");
  }
  return $usuario;

}
}
