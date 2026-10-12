<?php
declare(strict_types=1);

use App\Infraestructure\Adapter\In\Http\Controllers\AuthController;
use App\Infraestructure\Adapter\In\Http\Controllers\UsuarioController;
use App\Infraestructure\Adapter\Out\Persistence\PdoSessionRepository;
use App\Infraestructure\Adapter\Out\Persistence\PdoUserRepository;
use App\Infraestructure\Adapter\Out\Security\NativePasswordHasher;
use App\Infraestructure\Adapter\Out\Token\TokenManagerJWT;
use App\Infraestructure\Config\DatabaseConnection;
use App\Infraestructure\Config\Env;
use App\Ports\Services\LoginUsuarioUseCaseImpl;
use App\Ports\Services\LogoutUsuarioUseCaseImpl;
use App\Ports\Services\ObtenerUsuarioPorIdUseCaseImpl;
use App\Ports\Services\ObtenerUsuarioPorNombreUseCaseImpl;
use App\Ports\Services\RefrescarTokenUseCaseImpl;
use App\Ports\Services\RegistrarUsuarioUseCaseImpl;

// Carga las clases principales, las instancias correspondientes, si se quiere hacer un cambio en el
// handler de tokenManager se realiza aca, o si se quiere cambiar de base de datos.



return function (): array {
    Env::load(dirname(__DIR__, 2) . '/.env');

    // Adaptadores de salida
    $pdo               = DatabaseConnection::fromEnv();
    $userRepository    = new PdoUserRepository($pdo);
    $sessionRepository = new PdoSessionRepository($pdo);
    $passwordHasher    = new NativePasswordHasher();
    $tokenManager      = new TokenManagerJWT(Env::get('JWT_SECRET'));

    // Casos de uso + adaptadores de entrada
    return [
        'auth' => new AuthController(
            login: new LoginUsuarioUseCaseImpl($userRepository, $passwordHasher, $tokenManager, $sessionRepository),
            registrar: new RegistrarUsuarioUseCaseImpl($userRepository, $passwordHasher),
            refrescar: new RefrescarTokenUseCaseImpl($sessionRepository, $userRepository, $tokenManager),
            logout: new LogoutUsuarioUseCaseImpl($sessionRepository),
        ),
        'usuarios' => new UsuarioController(
            porId: new ObtenerUsuarioPorIdUseCaseImpl($userRepository),
            porNombre: new ObtenerUsuarioPorNombreUseCaseImpl($userRepository),
        ),
    ];
};
