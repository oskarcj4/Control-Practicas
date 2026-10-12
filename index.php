<?php
declare(strict_types=1);

use App\Infraestructure\Adapter\In\Http\JsonResponse;
use App\Infraestructure\Adapter\In\Http\Request;
use App\Infraestructure\Adapter\In\Http\Router;

require __DIR__. '/vendor/autoload.php';

date_default_timezone_set('America/Guatemala');

try {
    $container = (require __DIR__ . '/Infraestructure/Bootstrap/container.php');
    $controllers = $container();
    $router = new Router();
    $routes = require __DIR__ . '/Infraestructure/Adapter/In/Http/routes.php';
    $routes($router, $controllers);

    $response = $router->dispatch(Request::fromGlobals());
} catch (InvalidArgumentException $e) {
    $response = JsonResponse::error($e->getMessage(), 422);
} catch (DomainException $e) {
    $response = JsonResponse::error($e->getMessage(), 400);
} catch (Throwable $e) {
    error_log((string) $e);
    $response = JsonResponse::error($e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine(), 500);
}

$response->send();
