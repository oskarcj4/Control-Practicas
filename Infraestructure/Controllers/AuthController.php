<?php
declare(strict_types=1);
namespace App\Infraestructure\Adapter\In\Http\Controllers;

use App\Infraestructure\Adapter\In\Http\JsonResponse;
use App\Infraestructure\Adapter\In\Http\Request;
use App\Ports\In\Usuario\Login\LoginCommandRequest;
use App\Ports\In\Usuario\Login\LoginUsuarioUseCaseInterface;
use App\Ports\In\Usuario\Logout\LogoutUseCaseInterface;
use App\Ports\In\Usuario\Registrar\RegistrarUsuarioCommandRequest;
use App\Ports\In\Usuario\Registrar\RegistrarUsuarioUseCaseInterface;
use App\Ports\In\Usuario\Token\RefrescarTokenUseCaseInterface;

final readonly class AuthController
{
    public function __construct(
        private LoginUsuarioUseCaseInterface $login,
        private RegistrarUsuarioUseCaseInterface $registrar,
        private RefrescarTokenUseCaseInterface $refrescar,
        private LogoutUseCaseInterface $logout,
    ) {}

        public function register(Request $request): JsonResponse
    {
        $response = $this->registrar->execute(new RegistrarUsuarioCommandRequest(
            username: (string) $request->input('username', ''),
            nombre: (string) $request->input('nombre', ''),
            apellido: (string) $request->input('apellido', ''),
            email: (string) $request->input('email', ''),
            password: (string) $request->input('password', ''),
            carnet: (string) $request->input('carnet', ''),
            institucion_id: $request->input('institucion_id'),
            carrera_id: $request->input('carrera_id'),
            telefono: $request->input('telefono'),
            biografia: $request->input('biografia'),
        ));

        return JsonResponse::success('Usuario registrado', $response, 201);
    }

  public function login(Request $request): JsonResponse
    {
        $response = $this->login->execute(new LoginCommandRequest(
            identifier: (string) $request->input('identifier', ''),
            password: (string) $request->input('password', ''),
            userAgent: $request->userAgent,
            direccion_ip: $request->ip,
        ));

        return JsonResponse::success('Login correcto', $response);
    }

      public function refresh(Request $request): JsonResponse
    {
        $response = $this->refrescar->execute((string) $request->input('refresh_token', ''));

        return JsonResponse::success('Token renovado', $response);
    }

    public function logout(Request $request): JsonResponse
    {
        $this->logout->execute((string) $request->input('refresh_token', ''));

        return JsonResponse::success('Sesión cerrada');
    }
}
