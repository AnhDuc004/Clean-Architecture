<?php

namespace App\Infrastructure\Repositories;

use App\Domain\Repositories\TokenRepositoryInterface;
use Laravel\Sanctum\PersonalAccessToken;

class TokenRepository implements TokenRepositoryInterface
{
    public function extendToken(int $tokenId, \DateTimeInterface $newExpiry): bool
    {
        $token = PersonalAccessToken::find($tokenId);

        if (!$token) {
            return false;
        }

        $token->expires_at = $newExpiry;
        return $token->save();
    }
}
