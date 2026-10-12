<?php
declare(strict_types=1);
namespace App\Domain\Models;

use InvalidArgumentException;
final class HistorialEstadoPostulacion
{
    public ?int $id;
    public int $postulacion_id;
    public string $estado_anterior;
    public string $estado_nuevo;
    public int $actualizado_por;
    public ?string $comentario;
    public ?string $fecha;
    public function __construct(
        int $postulacion_id,
        string $estado_anterior,
        string $estado_nuevo,
        int $actualizado_por,
        ?string $comentario = null,
        ?string $fecha = null,
        ?int $id = null
    ) {
        if ($postulacion_id <= 0){
            throw new InvalidArgumentException("El id de la publicacion no puede ser negativo ni 0.");
        }
        $this->id = $id;
        $this->postulacion_id = $postulacion_id;
        $this->estado_anterior = $estado_anterior;
        $this->estado_nuevo = $estado_nuevo;
        $this->actualizado_por = $actualizado_por;
        $this->comentario = $comentario;
        $this->fecha = $fecha ?? date('Y-m-d H:i:s');
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function postulacion_id(): int
    {
        return $this->postulacion_id;
    }

    public function estado_anterior(): string
    {
        return $this->estado_anterior;
    }

    public function estado_nuevo(): string
    {
        return $this->estado_nuevo;
    }

    public function actualizado_por(): int
    {
        return $this->actualizado_por;
    }

    public function comentario(): ?string
    {
        return $this->comentario;
    }

    public function fecha(): ?string
    {
        return $this->fecha;
    }
}
