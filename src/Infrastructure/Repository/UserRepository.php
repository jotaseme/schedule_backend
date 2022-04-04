<?php

namespace App\Infrastructure\Repository;

use App\Domain\Schedule\User;
use App\Domain\Schedule\UserRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * Class UserRepository
 * @package App\Infrastructure\Repository
 */
class UserRepository extends ServiceEntityRepository implements UserRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, User::class);
    }

    /**
     * @inheritDoc
     */
    public function save(User $user): User
    {
        $this->_em->persist($user);
        $this->_em->flush();
        return $user;
    }
}
