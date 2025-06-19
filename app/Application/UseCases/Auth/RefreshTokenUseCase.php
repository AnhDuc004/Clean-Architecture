<?php

namespace App\Application\UseCases\Auth;

use App\Domain\Repositories\TokenRepositoryInterface;
use Illuminate\Contracts\Auth\Authenticatable;

class RefreshTokenUseCase
{
    private TokenRepositoryInterface $tokenRepository;

    public function __construct(TokenRepositoryInterface $tokenRepository)
    {
        $this->tokenRepository = $tokenRepository;
    }

    public function execute(Authenticatable $user): bool
    {
        $token = $user->currentAccessToken();

        if (!$token) {
            return false;
        }

        return $this->tokenRepository->extendToken($token->id, now()->addMinutes(60));
    }
}
