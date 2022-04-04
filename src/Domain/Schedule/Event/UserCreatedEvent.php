<?php

namespace App\Domain\Schedule\Event;

use App\Domain\Schedule\User;
use DateTimeInterface;

final class UserCreatedEvent
{
    public User              $user;
    public DateTimeInterface $createdAt;

    /**
     * @param User $user
     * @param DateTimeInterface $createdAt
     */
    public function __construct(User $user, DateTimeInterface $createdAt)
    {
        $this->user      = $user;
        $this->createdAt = $createdAt;
    }
}
