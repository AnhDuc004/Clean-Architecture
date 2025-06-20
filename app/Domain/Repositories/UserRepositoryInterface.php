<?php 

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepositoryInterface{
    public function create(array $data): User;

    public function getById(int $id): ?User;

    public function findByEmail(string $email): ?User;
}