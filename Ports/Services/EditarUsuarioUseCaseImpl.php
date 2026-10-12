<?php
declare(strict_types=1);

namespace App\Ports\Services;
use App\Ports\In\Usuario\Login\LoginCommandRequest;
use App\Ports\In\Usuario\Login\LoginCommandResponse;
use App\Ports\In\Usuario\Login\LoginUsuarioUseCaseInterface;

use App\Ports\Out\PasswordHasherInterface;
use App\Ports\Out\TokenManagerInterface;
use App\Ports\Out\UserRepositoryInterface;
use App\Ports\Out\SessionRepositoryInterface;

use DateTime;
use DomainException;

final class EditarUsuarioUseCaseImpl implements EditarUsuarioUseCaseInterface
{
  public function __construct(){
    private UserRepositoryInterface $usuarioRepository;
  }

  public function execute(LoginCommandRequest $request): LoginCommandResponse{

  }

}
