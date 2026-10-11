<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\In\Http;

final class Router
{
    private array $routes = [];

    // EJEM: GET/POST, URL () '/api/usuarios/{id}', METODO QUE MANEJA LA PETICION
    public function add(string $method, string $pattern, callable $handler): void
    {
        $regex = '#^' . preg_replace('#\{(\w+)\}#', '(?P<$1>[^/]+)', $pattern) . '$#';

        // El regex extrae los datos utiles para guardar en un arreglo.
        $this->routes[] = [$method, $regex, $handler];
    }

    public function dispatch(Request $request): JsonResponse
    {
        foreach ($this->routes as [$method, $regex, $handler]) {
          // Valida si el metodo del handler coincide y que la ruta encaje con la expresion regular
            if ($method === $request->method && preg_match($regex, $request->path, $matches)) {
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                return $handler($request->withParams($params));
            }
        }

        return JsonResponse::error('Ruta no encontrada', 404);
    }
}
