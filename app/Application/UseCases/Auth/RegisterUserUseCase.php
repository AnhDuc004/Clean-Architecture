<?php 

namespace App\Application\UseCases\Auth;

use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepositoryInterface;

class RegisterUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepo ) {}

    public function execute(array $data): User
    {
        return $this->userRepo->create($data);
    }
}