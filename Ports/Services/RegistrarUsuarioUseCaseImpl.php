<?php
declare(strict_types=1);
namespace App\Ports\Services;

use App\Domain\Models\Usuario;
use App\Ports\In\Usuario\Registrar\RegistrarUsuarioCommandRequest;
use App\Ports\In\Usuario\Registrar\RegistrarUsuarioCommandResponse;
use App\Ports\In\Usuario\Registrar\RegistrarUsuarioUseCaseInterface;
use App\Ports\Out\PasswordHasherInterface;
use App\Ports\Out\UserRepositoryInterface;
use DomainException;

final class RegistrarUsuarioUseCaseImpl implements RegistrarUsuarioUseCaseInterface
{
    public function __construct(
        private UserRepositoryInterface $usuarioRepository,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function execute(RegistrarUsuarioCommandRequest $request): RegistrarUsuarioCommandResponse
    {
        if ($this->usuarioRepository->findByEmail($request->email) !== null) {
            throw new DomainException("El email {$request->email} ya está en uso.");
        }

        if ($this->usuarioRepository->findByUsername($request->username) !== null) {
            throw new DomainException("El nombre de usuario {$request->username} ya existe.");
        }

        // Delegamos el hash al puerto, sin funciones globales directas
        $passwordHash = $this->passwordHasher->hash($request->password);

        $usuario = new Usuario(
            username: $request->username,
            nombre: $request->nombre,
            email: $request->email,
            password_hash: $passwordHash,
            rol_id: 1,
            institucion_id: $request->institucion_id,
            carrera_id: $request->carrera_id,
            carnet: $request->carnet,
            telefono: $request->telefono,
            biografia: $request->biografia,
            autorizado_publicar: false,
        );

        $this->usuarioRepository->save($usuario);

        return new RegistrarUsuarioCommandResponse(
            username: $usuario->username,
            email: $usuario->email,
            autorizado_publicar: $usuario->autorizado_publicar,
            nombre: $usuario->nombre,
            institucion_id: $usuario->institucion_id,
        );
    }
}
