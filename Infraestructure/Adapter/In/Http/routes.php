<?php
declare(strict_types=1);

use App\Infraestructure\Adapter\In\Http\Router;


return function (Router $router, array $c): void {
    $router->add('POST', '/api/auth/register', [$c['auth'], 'register']);
    $router->add('POST', '/api/auth/login',    [$c['auth'], 'login']);
    $router->add('POST', '/api/auth/refresh',  [$c['auth'], 'refresh']);
    $router->add('POST', '/api/auth/logout',   [$c['auth'], 'logout']);

    $router->add('GET', '/api/usuarios',      [$c['usuarios'], 'findByUsername']);
    $router->add('GET', '/api/usuarios/{id}', [$c['usuarios'], 'show']);
};
