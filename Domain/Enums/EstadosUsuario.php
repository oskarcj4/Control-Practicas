<?php
declare(strict_types= 1);
namespace App\Domain\Enums;

final class EstadosUsuario
{
    public const ACTIVO = 'ACTIVO';
    public const INACTIVO = 'INACTIVO';
    public const PENDIENTE = 'PENDIENTE';

    private function __construct() {}
}
