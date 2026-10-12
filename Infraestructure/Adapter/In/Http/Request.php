<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\In\Http;

final class Request
{
    public function __construct(
        public string $method,
        public string $path,
        public array $query,
        public array $body,
        public array $headers= [],
        public array $params = [],
        public ?string $userAgent = null,
        public ?string $ip = null,
    ) {}

    public static function fromGlobals(): self
    {
        $basePath = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) ?? '/';

        if ($basePath !== '' && str_starts_with($path, $basePath)) {
            $path = substr($path, strlen($basePath));
        }

        $body = json_decode(file_get_contents('php://input') ?: '[]', true);


        $headers = [];
        if(function_exists('getallheaders')){

            foreach(getallheaders() as $name => $value){
                $headers[strtolower((string) $name)] = (string) $value;

            }
        }else {
            foreach($_SERVER as $name => $value){
                if(str_starts_with($name, 'HTTP_')){
                    $headerName = strtolower(str_replace("_", "-", substr($name, 5)));
                    $headers[$headerName] = (string) $value;
                }
            }
        }

        if (!isset($headers['authorization'])) {
            if (isset($_SERVER['HTTP_AUTHORIZATION'])) {
                $headers['authorization'] = (string) $_SERVER['HTTP_AUTHORIZATION'];
            } elseif (isset($_SERVER['REDIRECT_HTTP_AUTHORIZATION'])) {
                $headers['authorization'] = (string) $_SERVER['REDIRECT_HTTP_AUTHORIZATION'];
            }
        }
        return new self(
            method: $_SERVER['REQUEST_METHOD'],
            path: '/' . trim($path, '/'),
            query: $_GET,
            body: is_array($body) ? $body : [],
            headers: $headers,
            userAgent: $_SERVER['HTTP_USER_AGENT'] ?? null,
            ip: $_SERVER['REMOTE_ADDR'] ?? null,
        );
    }

    public function withParams(array $params): self
    {
        return new self(
            $this->method,
            $this->path,
            $this->query,
            $this->body,
            $this->headers,
            $params,
            $this->userAgent,
            $this->ip
        );
    }

    public function header(string $key, ?string $default = null): ?string
    {
        return $this->headers[strtolower($key)] ?? $default;
    }

    public function bearerToken(): ?string
    {
        $auth = $this->header('authorization');
        if ($auth !== null && preg_match('/Bearer\s+(\S+)/i', $auth, $matches)) {
            return $matches[1];
        }

        return null;
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $default;
    }
}
