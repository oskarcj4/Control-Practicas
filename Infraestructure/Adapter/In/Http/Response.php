<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\In\Http;

final readonly class JsonResponse
{
    public function __construct(
        public int $status,
        public array $payload
    ) {}

    public static function success(string $message, mixed $data = null, int $status = 200): self
    {
        return new self($status, ['message' => $message, 'data' => $data]);
    }

    public static function error(string $message, int $status): self
    {
        return new self($status, ['message' => $message]);
    }

    public function send(): void
    {
        http_response_code($this->status);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($this->payload, JSON_UNESCAPED_UNICODE);
    }
}
