<?php
declare(strict_types= 1);
namespace App\Ports\Services;

use App\Ports\In\Usuario\Token\RefrescarTokenUseCaseInterface;
use App\Ports\In\Usuario\Token\RefreshTokenResponse;
use App\Ports\Out\SessionRepositoryInterface;
use App\Ports\Out\TokenManagerInterface;
use App\Ports\Out\UserRepositoryInterface;
use DateTimeImmutable;
use DomainException;

final class RefrescarTokenUseCaseImpl implements RefrescarTokenUseCaseInterface
{

  public function __construct(
    private SessionRepositoryInterface $sessionRepository,
    private UserRepositoryInterface $userRepository,
    private TokenManagerInterface $tokenManager
  ){}

  public function execute(string $rawRefreshToken) : RefreshTokenResponse  {
    $hash = hash('sha256', $rawRefreshToken);
    $session = $this->sessionRepository->findByRefreshTokenHash($hash);
    if ($session === null || $session->revocado || $session->expira_en <= new DateTimeImmutable()){
      throw new DomainException('Sesión inválida o expirada. Inicie sesión nuevamente.');
    }

    $usuario = $this->userRepository->findById($session->usuario_id);
    if ($usuario === null) {
        throw new DomainException('El usuario asociado a la sesión ya no existe.');
    }

    $nuevoAccessToken = $this->tokenManager->generateAccessToken(
            user_id: $usuario->id,
            username: $usuario->username,
            rol_id: $usuario->rol_id
        );

      return new RefreshTokenResponse(
            accessToken: $nuevoAccessToken,
            expiresInSeconds: 900
        );

  }


}
