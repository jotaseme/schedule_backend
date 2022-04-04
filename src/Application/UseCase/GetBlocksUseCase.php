<?php

namespace App\Application\UseCase;

use App\Domain\Schedule\BlockRepositoryInterface;
use App\Domain\Shared\Security\SecurityTokenInterface;

class GetBlocksUseCase
{
    private BlockRepositoryInterface $repository;

    private SecurityTokenInterface $securityToken;

    /**
     * @param BlockRepositoryInterface $repository
     * @param SecurityTokenInterface $securityToken
     */
    public function __construct(BlockRepositoryInterface $repository, SecurityTokenInterface $securityToken)
    {
        $this->repository    = $repository;
        $this->securityToken = $securityToken;
    }

    /**
     * @param string|null $from
     * @param string|null $to
     * @return iterable
     */
    public function execute(?string $from, ?string $to): iterable
    {
        return $this->repository->filter(
            ['from' => $from, 'to' => $to],
            $this->securityToken->getUser()->getEmail()
        );
    }
}
