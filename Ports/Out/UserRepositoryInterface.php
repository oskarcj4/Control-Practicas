<?php
declare(strict_types= 1);

namespace App\Ports\Out;

use App\Domain\Models\Usuario;

interface UserRepositoryInterface{
  public function save(Usuario $user): void;
  public function findByUsername(string $username): ?Usuario;
  public function findByEmail(string $email): ?Usuario;
  public function findById(int $id): ?Usuario;

  public function existsByEmailExceptId(string $email, int $id): bool;
    public function updateProfile(int $id, ?string $username, ?string $nombre, ?string $apellido, ?string $email, ?string $carnet, ?int $institucion_id , ?int $carrera_id , ?string $telefono , ?string $biografia,): void;
  }
