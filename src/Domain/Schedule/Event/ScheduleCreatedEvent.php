<?php

namespace App\Domain\Schedule\Event;

use App\Domain\Schedule\Schedule;
use DateTimeInterface;

final class ScheduleCreatedEvent
{
    public Schedule          $schedule;
    public DateTimeInterface $createdAt;

    /**
     * @param $schedule
     * @param DateTimeInterface $createdAt
     */
    public function __construct($schedule, DateTimeInterface $createdAt)
    {
        $this->schedule  = $schedule;
        $this->createdAt = $createdAt;
    }
}
