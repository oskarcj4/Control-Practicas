<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\In\Http\Controllers;

use App\Domain\Models\Usuario;
use App\Infraestructure\Adapter\In\Http\JsonResponse;
use App\Infraestructure\Adapter\In\Http\Request;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorIdUseCaseInterface;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorNombreUseCaseInterface;

final class UsuarioController
{
    public function __construct(
        private ObtenerUsuarioPorIdUseCaseInterface $porId,
        private ObtenerUsuarioPorNombreUseCaseInterface $porNombre,
    ) {}

    public function show(Request $request): JsonResponse
    {
        $usuario = $this->porId->execute((int) $request->params['id']);

        return JsonResponse::success('Usuario encontrado', $this->toArray($usuario));
    }

    public function findByUsername(Request $request): JsonResponse
    {
        $usuario = $this->porNombre->execute((string) ($request->query['username'] ?? ''));

        return JsonResponse::success('Usuario encontrado', $this->toArray($usuario));
    }

    // Nunca devolver password_hash al cliente.
    private function toArray(Usuario $u): array
    {
        return [
            'id'             => $u->id,
            'username'       => $u->username,
            'nombre'         => $u->nombre,
            'apellido'       => $u->apellido,
            'email'          => $u->email,
            'rol_id'         => $u->rol_id,
            'institucion_id' => $u->institucion_id,
            'carrera_id'     => $u->carrera_id,
            'estado'         => $u->estado->value,
        ];
    }
}
