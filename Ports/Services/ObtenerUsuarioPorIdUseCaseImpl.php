<?php
declare(strict_types=1);

namespace App\Ports\Services;

use App\Domain\Models\Usuario;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorIdUseCaseInterface;
use App\Ports\Out\UserRepositoryInterface;
use DomainException;

final class ObtenerUsuarioPorIdUseCaseImpl implements ObtenerUsuarioPorIdUseCaseInterface
{
    public function __construct(
        private UserRepositoryInterface $usuarioRepository
    ) {}

    public function execute(int $id): Usuario
    {
        if ($id <= 0) {
            throw new DomainException("El ID del usuario debe ser un número entero positivo.");
        }

        $usuario = $this->usuarioRepository->findById($id);

        if ($usuario === null) {
            throw new DomainException("El usuario con ID {$id} no existe.");
        }

        return $usuario;
    }
}
