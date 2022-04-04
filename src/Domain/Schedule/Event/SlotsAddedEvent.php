<?php

namespace App\Domain\Schedule\Event;

use DateTimeInterface;

final class SlotsAddedEvent
{
    public DateTimeInterface $createdAt;

    /**
     * @param DateTimeInterface $createdAt
     */
    public function __construct(DateTimeInterface $createdAt)
    {
        $this->createdAt = $createdAt;
    }
}
