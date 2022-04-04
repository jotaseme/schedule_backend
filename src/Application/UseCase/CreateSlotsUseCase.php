<?php

namespace App\Application\UseCase;

use App\Domain\Schedule\Slot;
use App\Domain\Schedule\UserRepositoryInterface;
use App\Domain\Shared\Security\SecurityTokenInterface;
use Exception;

class CreateSlotsUseCase
{
    private UserRepositoryInterface $repository;
    private SecurityTokenInterface  $securityToken;

    /**
     * @param UserRepositoryInterface $repository
     * @param SecurityTokenInterface $securityToken
     */
    public function __construct(UserRepositoryInterface $repository, SecurityTokenInterface $securityToken)
    {
        $this->repository    = $repository;
        $this->securityToken = $securityToken;
    }

    /**
     * @param string|null $slots
     * @return iterable<Slot>
     * @throws Exception
     */
    public function execute(?string $slots = null): iterable
    {
        $user = $this->securityToken->getUser();
        $user->addSlots(Slot::createCollection($user, json_decode($slots, true)));

        return $this->repository->save($user)->getSlots();
    }
}
