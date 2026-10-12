<?php
declare(strict_types=1);

use App\Infraestructure\Adapter\In\Http\Router;


return function (Router $router, array $c): void {

    $router->add('POST', '/api/auth/register', [$c['auth'], 'register']);

    /*EJEMPLO PETICION FORMATO JSON:

        {
        "username": "usuario_prueba",
        "nombre": "Juan",
        "apellido": "Pérez",
        "email": "juan.perez@example.com",
        "password": "Password123!",
        "carnet": "2026-00123",
        "institucion_id": 1,
        "carrera_id": 1,
        "telefono": "+50212345678",
        "biografia": "Estudiante de ingeniería"
        }

    */

    $router->add('POST', '/api/auth/login',    [$c['auth'], 'login']);
    /*
    EJEMPLO PETICION FORMATO JSON:
    {
            "identifier": "juan.perez@gmail.com",
            "password": "Password123!"

            }
    */

    $router->add('POST', '/api/auth/refresh',  [$c['auth'], 'refresh']);
    /*
    EJEMPLO PETICION FORMATO JSON:
    {
    "refresh_token": "d93446208069d4897000ff77a20f88174749d2021af15ec91185d48f2b796eed"
    }
    */

    $router->add('POST', '/api/auth/logout',   [$c['auth'], 'logout']);
    /*

    GET http://localhost/Control-Practicas/api/usuarios/3

    */

    $router->add('GET', '/api/usuarios',      [$c['usuarios'], 'findByUsername']);

    /*

    */



    $router->add('GET', '/api/usuarios/{id}', [$c['usuarios'], 'show']);

    /*

    GET http://localhost/Control-Practicas/api/usuarios/3

    */
};
