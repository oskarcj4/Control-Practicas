<?php
declare(strict_types=1);

namespace App\Ports\Services;

use App\Ports\Out\UserRepositoryInterface;

use DomainException;

final class EditarUsuarioUseCaseImpl implements EditarUsuarioUseCaseInterface
{
    private const ROL_ADMIN = 1; // Asumiendo que 1 es el ID del rol Administrador

    public function __construct(
        private UserRepositoryInterface $usuarioRepository
    ) {}

    public function execute(ActualizarUsuarioCommandRequest $command): void
    {
        $esAdmin = ($command->authenticatedRolId === self::ROL_ADMIN);
        $esMismoUsuario = ($command->authenticatedUserId === $command->usuarioIdTarget);

        if (!$esAdmin && !$esMismoUsuario) {
            throw new DomainException('No tienes permisos para modificar este perfil.');
        }

        // Regla 2: Verificar que el usuario exista
        $usuario = $this->usuarioRepository->findById($command->usuarioIdTarget);
        if ($usuario === null) {
            throw new RuntimeException('El usuario solicitado no existe.');
        }

        // Regla 3: Si se desea actualizar el email, validar que no pertenezca a otra cuenta
        if ($command->email !== null && $command->email !== $usuario->email) {
            if (!filter_var($command->email, FILTER_VALIDATE_EMAIL)) {
                throw new DomainException('El formato del correo electrónico no es válido.');
            }

            if ($this->usuarioRepository->existsByEmailExceptId($command->email, $command->usuarioIdTarget)) {
                throw new DomainException('El correo electrónico ya está registrado por otro usuario.');
            }
        }

        // Regla 4: Persistir solo los campos permitidos (nombre y email)
        $nuevoNombre = $command->nombre ?? $usuario->nombre;
        $nuevoEmail = $command->email ?? $usuario->email;

        $this->usuarioRepository->updateProfile($command->usuarioIdTarget, $nuevoNombre, $nuevoEmail);
    }
}
