<?php
declare(strict_types= 1);
namespace App\Domain\Enums;

final class EstadosUsuario
{
    public const ACTIVO = 'activo';
    public const INACTIVO = 'inactivo';
    public const SUSPENDIDO = 'suspendido';

    private function __construct() {}
}
