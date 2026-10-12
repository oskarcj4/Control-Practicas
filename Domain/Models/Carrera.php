<?php
declare(strict_types=1);
namespace App\Domain\Models;

use InvalidArgumentException;
final class Carrera
{
    public ?int $id;
    public int $institucion_id;
    public string $nombre;
    public ?string $codigo;
    public ?string $creado_en;

    public function __construct(
        int $institucion_id,
        string $nombre,
        ?string $codigo = null,
        ?string $creado_en = null,
        ?int $id = null
    ) {
        $this->id = $id;

        if(strlen($nombre) <= 2) {
            throw new InvalidArgumentException("El nombre debe tener una logitud de almenos 3 caracteres");
        }
        $this->institucion_id = $institucion_id;
        $this->nombre = $nombre;
        $this->codigo = $codigo;
        $this->creado_en = $creado_en ?? date('Y-m-d H:i:s');
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function institucion_id(): int
    {
        return $this->institucion_id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function codigo(): ?string
    {
        return $this->codigo;
    }

    public function creado_en(): ?string
    {
        return $this->creado_en;
    }
}
