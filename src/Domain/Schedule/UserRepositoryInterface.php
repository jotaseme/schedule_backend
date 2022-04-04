<?php

namespace App\Domain\Schedule;

interface UserRepositoryInterface
{
    /**
     * @param User $user
     * @return User
     */
    public function save(User $user): User;
}
