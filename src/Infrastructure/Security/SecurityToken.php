<?php

namespace App\Infrastructure\Security;

use App\Domain\Schedule\User;
use App\Domain\Schedule\UserRepositoryInterface;
use App\Domain\Shared\Security\SecurityTokenInterface;

class SecurityToken implements SecurityTokenInterface
{
    private UserRepositoryInterface $repository;

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @inheritDoc
     */
    public function getUser(): User
    {
        return $this->repository->findOneBy(['email' => 'a']);
    }
}
