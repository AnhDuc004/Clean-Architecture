<?php

namespace App\Domain\Repositories;

interface TokenRepositoryInterface
{
    public function extendToken(int $tokenId, \DateTimeInterface $newExpiry): bool;
}
