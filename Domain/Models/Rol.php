<?php
declare(strict_types=1);
namespace App\Domain\Models;

use InvalidArgumentException;
final class Rol
{
    public ?int $id;
    public string $nombre;
    public ?string $descripcion;
    public ?string $creado_en;

    public function __construct(
        string $nombre,
        ?string $descripcion = null,
        ?string $creado_en = null,
        ?int $id = null
    ) {
        if (!str_starts_with($nombre, "ROL_")) {

            throw new InvalidArgumentException("Todos los roles deben empezar con el prefijo 'ROL_'. ");
        }
        $this->id = $id;
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->creado_en = $creado_en ?? date('Y-m-d H:i:s');
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function descripcion(): ?string
    {
        return $this->descripcion;
    }

    public function creado_en(): ?string
    {
        return $this->creado_en;
    }
}
