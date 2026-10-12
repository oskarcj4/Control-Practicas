<?php
declare(strict_types=1);

namespace App\Ports\Services;
use App\Ports\In\Usuario\Logout\LogoutUseCaseInterface;
use App\Ports\Out\SessionRepositoryInterface;
use DomainException;

final class LogoutUsuarioUseCaseImpl implements LogoutUseCaseInterface {

  public function __construct(
    private SessionRepositoryInterface $sessionRepository
  ){}

  public function execute(string $rawRefreshToken): void {
    if(trim($rawRefreshToken) === ''){
      throw new DomainException("No se proporciono el token de refresco");
    }

    $tokenHash= hash('sha256', $rawRefreshToken);

    $this->sessionRepository->revoke($tokenHash);

  }


}
