<?php


namespace App\Domain\Shared\Security;

use App\Domain\Schedule\User;

/**
 * Interface SecurityTokenInterface
 * @package Face\Domain\Shared\Security
 */
interface SecurityTokenInterface
{
    /**
     * @return User
     */
    public function getUser(): User;
}
