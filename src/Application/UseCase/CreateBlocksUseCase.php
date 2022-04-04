<?php

namespace App\Application\UseCase;

use App\Domain\Schedule\Block;
use App\Domain\Schedule\User;
use App\Domain\Schedule\UserRepositoryInterface;
use Exception;

class CreateBlocksUseCase
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
     * @param string|null $email
     * @param string|null $from
     * @param string|null $to
     * @return iterable<Block>
     * @throws Exception
     */
    public function execute(?string $email, ?string $from, ?string $to): iterable
    {
        /** @var User $user */
        $user = $this->repository->findOneBy(['email' => $email]);
        return $this->repository->save(
            $user->addBlocks(Block::createCollection($user, $from, $to))
        )->getBlocks();
    }
}
