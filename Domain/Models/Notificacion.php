<?php
declare(strict_types=1);
namespace App\Domain\Models;

use InvalidArgumentException;
final class Notificacion
{
    public ?int $id;
    public int $usuario_id;
    public string $titulo;
    public string $mensaje;
    public ?string $link_accion;
    public bool $leido;
    public ?string $fecha_creacion;
    public function __construct(
        int $usuario_id,
        string $titulo,
        string $mensaje,
        ?string $link_accion = null,
        bool $leido = false,
        ?string $fecha_creacion = null,
        ?int $id = null
    ) {
        $this->id = $id;

        if (strlen($titulo) <= 2 || strlen($mensaje) <= 5) {
            throw new InvalidArgumentException("El formato de la notificacion es invalido");
        }
        if ($usuario_id <= 0){
            throw new InvalidArgumentException("El ID de usuario no puede ser negativo ni 0.");
        }

        $this->usuario_id = $usuario_id;
        $this->titulo = $titulo;
        $this->mensaje = $mensaje;
        $this->link_accion = $link_accion;
        $this->leido = $leido;
        $this->fecha_creacion = $fecha_creacion ?? date('Y-m-d H:i:s');
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function usuario_id(): int
    {
        return $this->usuario_id;
    }

    public function titulo(): string
    {
        return $this->titulo;
    }

    public function mensaje(): string
    {
        return $this->mensaje;
    }

    public function link_accion(): ?string
    {
        return $this->link_accion;
    }

    public function leido(): bool
    {
        return $this->leido;
    }

    public function fecha_creacion(): ?string
    {
        return $this->fecha_creacion;
    }
}
