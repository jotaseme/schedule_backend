<?php

namespace App\Domain\Schedule;

use Doctrine\ORM\QueryBuilder;

interface BlockRepositoryInterface
{
    /**
     * @param string $email
     * @return QueryBuilder
     */
    public function getAllByUserQb(string $email): QueryBuilder;

    /**
     * @param array $criteria
     * @param string $email
     * @return iterable
     */
    public function filter(array $criteria, string $email): iterable;
}
