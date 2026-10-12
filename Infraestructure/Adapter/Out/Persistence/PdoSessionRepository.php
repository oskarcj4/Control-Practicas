<?php
declare(strict_types=1);

namespace App\Infraestructure\Adapter\Out\Persistence;

use App\Domain\Models\SesionUsuario;
use App\Ports\Out\SessionRepositoryInterface;
use DateTime;
use DateTimeImmutable;
use PDO;

final class PdoSessionRepository implements SessionRepositoryInterface
{
  public function __construct(private PDO $pdo) {}

  public function findByRefreshTokenHash(string $refreshTokenHash): ?SesionUsuario
  {
    $stmt = $this->pdo->prepare(
      "SELECT * FROM sesiones_usuario WHERE refresh_token_hash = :refreshTokenHash"
    );

    $stmt->execute([
      'refreshTokenHash' => $refreshTokenHash,
    ]);

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($row === false) {
      return null;
    }

    return new SesionUsuario(
      usuario_id: (int) $row['usuario_id'],
      refresh_token_hash: $row['refresh_token_hash'],
      expira_en: new DateTimeImmutable($row['expira_en']),
      user_agent: $row['user_agent'],
      ip_address: $row['direccion_ip'],
      revocado: (bool) $row['revocado'],
      creado_en: new DateTimeImmutable($row['creado_en']),
      id: (int) $row['id'],
    );
  }

  public function save(
    int $usuarioId,
    string $refreshTokenHash,
    DateTime $expiraEn,
    ?string $userAgent = null,
    ?string $ipAddress = null
  ): void {
    $stmt = $this->pdo->prepare(
      "INSERT INTO sesiones_usuario (usuario_id, refresh_token_hash, user_agent, direccion_ip, expira_en)
      VALUES (:usuarioId, :refreshTokenHash, :userAgent, :ipAddress, :expiraEn)"
    );

    $stmt->execute([
      'usuarioId' => $usuarioId,
      'refreshTokenHash' => $refreshTokenHash,
      'userAgent' => $userAgent,
      'ipAddress' => $ipAddress,
      'expiraEn' => $expiraEn->format('Y-m-d H:i:s'),
    ]);
  }

  public function revoke(string $refreshTokenHash): void
  {
    $stmt = $this->pdo->prepare(
      "UPDATE sesiones_usuario SET revocado = 1 WHERE refresh_token_hash = :refreshTokenHash"
    );

    $stmt->execute([
      'refreshTokenHash' => $refreshTokenHash,
    ]);
  }

  public function revoke_all(int $usuarioId): void
  {
    $stmt = $this->pdo->prepare(
      "UPDATE sesiones_usuario SET revocado = 1 WHERE usuario_id = :usuarioId AND revocado = 0"
    );

    $stmt->execute([
      'usuarioId' => $usuarioId,
    ]);
  }
}
