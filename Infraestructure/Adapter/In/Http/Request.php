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

        return new self(
            method: $_SERVER['REQUEST_METHOD'],
            path: '/' . trim($path, '/'),
            query: $_GET,
            body: is_array($body) ? $body : [],
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
            $params,
            $this->userAgent,
            $this->ip
        );
    }

    public function input(string $key, mixed $default = null): mixed
    {
        return $this->body[$key] ?? $default;
    }
}
