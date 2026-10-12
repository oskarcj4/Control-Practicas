<?php
declare(strict_types=1);
namespace App\Domain\Models;

use InvalidArgumentException;
final class Institucion
{
    public ?int $id;
    public string $nombre;
    public ?string $siglas;
    public string $tipo;
    public ?string $contacto_email;
    public ?string $sitio_web;
    public ?string $creado_en;

    public function __construct(
        string $nombre,
        string $tipo = 'empresa',
        ?string $siglas = null,
        ?string $contacto_email = null,
        ?string $sitio_web = null,
        ?string $creado_en = null,
        ?int $id = null
    ) {
        if (strlen($nombre) <= 2) {
            throw new InvalidArgumentException('El nombre de la empresa debe tener al menos 3 caracteres de longitud');
        }
        $this->id = $id;
        $this->nombre = $nombre;
        $this->tipo = $tipo;
        $this->siglas = $siglas;
        $this->contacto_email = $contacto_email;
        $this->sitio_web = $sitio_web;
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

    public function siglas(): ?string
    {
        return $this->siglas;
    }

    public function tipo(): string
    {
        return $this->tipo;
    }

    public function contacto_email(): ?string
    {
        return $this->contacto_email;
    }

    public function sitio_web(): ?string
    {
        return $this->sitio_web;
    }

    public function creado_en(): ?string
    {
        return $this->creado_en;
    }
}
