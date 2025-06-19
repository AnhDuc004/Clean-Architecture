<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\UserRepositoryInterface;
use App\Domain\Entities\User as DomainUser;
use App\Models\User;

class UserRepository implements UserRepositoryInterface
{
    public function create(array $data): DomainUser
    {
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
        if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail) {
            $user->sendEmailVerificationNotification();
        }
        return new DomainUser($user->id, $user->name, $user->email);
    }

    public function findByEmail(string $email): ?DomainUser
    {
        $user = User::where('email', $email)->first();
        return $user ? new DomainUser($user->id, $user->name, $user->email) : null;
    }

    public function getById(int $id): ?DomainUser
    {
        $user = User::find($id);
        return $user ? new DomainUser($user->id, $user->name, $user->email) : null;
    }
}
