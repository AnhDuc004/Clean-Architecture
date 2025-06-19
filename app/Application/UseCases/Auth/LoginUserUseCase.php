<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Models\User as EloquentUser;
use Illuminate\Support\Facades\Hash;

class LoginUserUseCase
{
    public function __construct(private UserRepositoryInterface $userRepo) {}

    public function execute(string $email, string $password): ?EloquentUser
    {       
        $user = $this->userRepo->findByEmail($email);

        if (!$user) {
            return null;
        }

        $eloquentUser = EloquentUser::find($user->getId());

        if (!$eloquentUser || !Hash::check($password, $eloquentUser->password)) {
            return null;
        }

        return $eloquentUser;
    }
}
