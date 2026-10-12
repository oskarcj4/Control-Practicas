<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\Out\Persistence;

use App\Domain\Enums\EstadosUsuario;
use App\Domain\Models\Usuario;
use App\Ports\Out\UserRepositoryInterface;
use DateTime;
use PDO;

final class PdoUserRepository implements UserRepositoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function save(Usuario $user): void
  {
    $stmt = $this->pdo->prepare(
      "INSERT INTO usuarios (username, nombre, apellido, email, password_hash, rol_id, institucion_id, carrera_id, carnet, telefono, biografia, autorizado_publicar, estado, fecha_registro)
      VALUES (:username, :nombre, :apellido, :email, :password_hash, :rol_id, :institucion_id, :carrera_id, :carnet, :telefono, :biografia, :autorizado_publicar, :estado, :fecha_registro)"
    );

    $stmt->execute([
      'username' => $user->username(),
      'nombre' => $user->nombre(),
      'apellido' => $user->apellido(),
      'email' => $user->email(),
      'password_hash' => $user->password_hash(),
      'rol_id' => $user->rol_id(),
      'institucion_id' => $user->institucion_id(),
      'carrera_id' => $user->carrera_id(),
      'carnet' => $user->carnet(),
      'telefono' => $user->telefono(),
      'biografia' => $user->biografia(),
      'autorizado_publicar' => (int) $user->autorizado_publicar(),
      'estado' => $user->estado(),
      'fecha_registro' => $user->fecha_registro()->format('Y-m-d H:i:s'),
    ]);

    $user->id = (int) $this->pdo->lastInsertId();
  }

  public function findById(int $id): ?Usuario
  {
    $stmt = $this->pdo->prepare(
      "SELECT * FROM usuarios WHERE id = :id"
    );

    $stmt->execute([
      "id" => $id
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
      return null;
    }

    return new Usuario(
      username: $row["username"],
      nombre: $row["nombre"],
      apellido: $row["apellido"],
      email: $row["email"],
      password_hash: $row["password_hash"],
      rol_id: (int) $row["rol_id"],
      institucion_id: $row["institucion_id"] !== null ? (int) $row["institucion_id"] : null,
      carrera_id: $row["carrera_id"] !== null ? (int) $row["carrera_id"] : null,
      carnet: $row["carnet"],
      telefono: $row["telefono"],
      biografia: $row["biografia"],
      autorizado_publicar: (bool) $row["autorizado_publicar"],
      estado: $row["estado"],
      fecha_registro: new DateTime($row["fecha_registro"]),
      id: (int) $row["id"],
    );
  }

  public function findByEmail(string $email): ?Usuario {
    $stmt = $this->pdo->prepare(
      "SELECT * FROM usuarios WHERE email = :email"
    );

    $stmt->execute([
      "email" => $email
    ]);

    $row=$stmt->fetch(PDO::FETCH_ASSOC);
    if($row===false){
      return null;
    }
    return new Usuario(
      username: $row["username"],
      nombre: $row["nombre"],
      apellido: $row["apellido"],
      email: $row["email"],
      password_hash: $row["password_hash"],
      rol_id: (int) $row["rol_id"],
      institucion_id: $row["institucion_id"] !== null ? (int) $row["institucion_id"] : null,
      carrera_id: $row["carrera_id"] !== null ? (int) $row["carrera_id"] : null,
      carnet: $row["carnet"],
      telefono: $row["telefono"],
      biografia: $row["biografia"],
      autorizado_publicar: (bool) $row["autorizado_publicar"],
      estado: $row["estado"],
      fecha_registro: new DateTime($row["fecha_registro"]),
      id: (int) $row["id"],
    );
  }

  public function findByUsername(string $username): ?Usuario{
    $stmt = $this->pdo->prepare("SELECT * FROM usuarios WHERE username=:username");

    $stmt->execute(['username'=>$username]);

    $row= $stmt->fetch(PDO::FETCH_ASSOC);

    if($row===false) return null;

      return new Usuario(
        username: $row["username"],
        nombre: $row["nombre"],
        apellido: $row["apellido"],
        email: $row["email"],
        password_hash: $row["password_hash"],
        rol_id: (int) $row["rol_id"],
        institucion_id: $row["institucion_id"] !== null ? (int) $row["institucion_id"] : null,
        carrera_id: $row["carrera_id"] !== null ? (int) $row["carrera_id"] : null,
        carnet: $row["carnet"],
        telefono: $row["telefono"],
        biografia: $row["biografia"],
        autorizado_publicar: (bool) $row["autorizado_publicar"],
        estado: EstadosUsuario::from($row["estado"]),
        fecha_registro: new DateTime($row["fecha_registro"]),
        id: (int) $row["id"],
    );

  }

}
