<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\In\Http\Controllers;

use App\Domain\Models\Usuario;
use App\Infraestructure\Adapter\In\Http\JsonResponse;
use App\Infraestructure\Adapter\In\Http\Request;
use App\Ports\In\Usuario\Editar\EditarCommandRequest;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorIdUseCaseInterface;
use App\Ports\In\Usuario\Obtener\ObtenerUsuarioPorNombreUseCaseInterface;
use App\Ports\In\Usuario\Editar\EditarUsuarioUseCaseInterface;
use App\Ports\Out\TokenManagerInterface;
use DomainException;
use RuntimeException;
use Throwable;
final class UsuarioController
{
    public function __construct(
        private ObtenerUsuarioPorIdUseCaseInterface $porId,
        private ObtenerUsuarioPorNombreUseCaseInterface $porNombre,
        private EditarUsuarioUseCaseInterface $editar,
        private TokenManagerInterface $token
    ) {}


    public function edit(Request $request): JsonResponse{
        $token =$request ->bearerToken();
        if($token ===null){
            return JsonResponse::error('Token de autorización no proporcionado.', 401);
        }
        try {
            $tokenPayload = $this->token->validateAccessToken($token);
        } catch (Throwable) {
            return JsonResponse::error('Token inválido o expirado.', 401);
        }

        $targetId= (int) ($request->params["id"] ?? 0);

        if ($targetId <= 0){
            return JsonResponse::error('El ID de usuario no es valido.', 400);
        }

        $command = new EditarCommandRequest(
            usuarioIdTarget: $targetId,
            username: $request->input('username'),
            nombre: $request->input('nombre'),
            apellido: $request->input('apellido'),
            email: $request->input('email'),
            carnet: $request->input('carnet'),
            institucion_id: $request->input('institucion_id') !== null ? (int) $request->input('institucion_id') : null,
            carrera_id: $request->input('carrera_id') !== null ? (int) $request->input('carrera_id') : null,
            telefono: $request->input('telefono'),
            biografia: $request->input('biografia'),
            authenticatedUserId: (int) $tokenPayload['user_id'],
            authenticatedRolId: (int) $tokenPayload['rol_id']
         );

         try{
            $this->editar->execute($command);
            return JsonResponse::success("Usuario editado exitosamente", 201);
         }
         catch(DomainException $e){
            return JsonResponse::error($e->getMessage(), 403);
         }
         catch(RuntimeException $e){
            return JsonResponse::error($e->getMessage(), 404);
         }
         catch(Throwable $e){ //Usar $e para debugging
            return JsonResponse::error('Error en el servidor', 500);
         }


    }
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
            'estado'         => $u->estado,
        ];
    }
}
