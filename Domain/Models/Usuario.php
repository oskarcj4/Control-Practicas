<?php
declare(strict_types=1);

namespace App\Domain\Models;

use App\Domain\Enums\EstadosUsuario;
use DateTime;
use InvalidArgumentException;

class Usuario
{
    public ?int $id;
    public string $username;
    public string $nombre;
    public string $apellido;
    public string $email;
    public string $password_hash;
    public int $rol_id;
    public ?int $institucion_id;
    public ?int $carrera_id;
    public ?string $carnet;
    public ?string $telefono;
    public ?string $biografia;
    public bool $autorizado_publicar;
    public string $estado;
    public DateTime $fecha_registro;

    public function __construct(
        string $username,
        string $nombre,
        string $apellido,
        string $email,
        string $password_hash,
        int $rol_id,
        ?int $institucion_id = null,
        ?int $carrera_id = null,
        ?string $carnet = null,
        ?string $telefono = null,
        ?string $biografia = null,
        bool $autorizado_publicar = false,
        string $estado = EstadosUsuario::ACTIVO,
        ?DateTime $fecha_registro = null,
        ?int $id = null
    ) {
        if ($institucion_id !== null && $institucion_id <= 0) {
            throw new InvalidArgumentException('El ID de la institución no es válido.');
        }

        if ($carrera_id !== null && $carrera_id <= 0) {
            throw new InvalidArgumentException('El ID de la carrera no es válido.');
        }
        if (strlen($nombre) <= 2) {
            throw new InvalidArgumentException('La longitud del nombre es muy corta');
        }

        if (strlen($apellido) <= 2) {
            throw new InvalidArgumentException('La longitud del apellido es muy corta');
        }

        if (strlen($username) <= 3) {
            throw new InvalidArgumentException('La longitud del username no es valida');
        }

        if (strlen($password_hash) < 8) {
            throw new InvalidArgumentException('La longitud de la contraseña debe ser de al menos 8 caracteres');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($email) <= 5) {
            throw new InvalidArgumentException("El email '{$email}' no es valido.");
        }

        $this->id = $id;
        $this->username = $username;
        $this->nombre = $nombre;
        $this->apellido = $apellido;
        $this->email = strtolower(trim($email));
        $this->password_hash = $password_hash;
        $this->rol_id = $rol_id;
        $this->institucion_id = $institucion_id;
        $this->carrera_id = $carrera_id;
        $this->carnet = $carnet;
        $this->telefono = $telefono;
        $this->biografia = $biografia;
        $this->autorizado_publicar = $autorizado_publicar;
        $this->estado = $estado;
        $this->fecha_registro = $fecha_registro ?? new DateTime();
    }

    public function id(): ?int
    {
        return $this->id;
    }

    public function username(): string
    {
        return $this->username;
    }

    public function nombre(): string
    {
        return $this->nombre;
    }

    public function apellido(): string
    {
        return $this->apellido;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password_hash(): string
    {
        return $this->password_hash;
    }

    public function rol_id(): int
    {
        return $this->rol_id;
    }

    public function institucion_id(): ?int
    {
        return $this->institucion_id;
    }

    public function carrera_id(): ?int
    {
        return $this->carrera_id;
    }

    public function carnet(): ?string
    {
        return $this->carnet;
    }

    public function telefono(): ?string
    {
        return $this->telefono;
    }

    public function biografia(): ?string
    {
        return $this->biografia;
    }

    public function autorizado_publicar(): bool
    {
        return $this->autorizado_publicar;
    }

    public function estado(): string
    {
        return $this->estado;
    }

    public function fecha_registro(): DateTime
    {
        return $this->fecha_registro;
    }
}
