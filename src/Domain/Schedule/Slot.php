<?php

namespace App\Domain\Schedule;

use DateTimeInterface;
use Exception;

abstract class Slot
{
    const MEAL     = 'MEAL';
    const TRAINING = 'TRAINING';
    const DAYS = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];

    private int $id;

    protected User $user;

    protected DateTimeInterface $startAt;

    protected DateTimeInterface $endAt;

    /**
     * @param User $user
     * @param DateTimeInterface $startAt
     * @param DateTimeInterface $endAt
     */
    protected function __construct(User $user, DateTimeInterface $startAt, DateTimeInterface $endAt)
    {
        $this->user    = $user;
        $this->startAt = $startAt;
        $this->endAt   = $endAt;
    }

    /**
     * @param User $user
     * @param array|null $slots
     * @return array
     * @throws Exception
     */
    public static function createCollection(User $user, ?array $slots): array
    {
        if (null === $slots) {
            throw new Exception("This value can not be null");
        }
        if (!array_key_exists('type', $slots) ||
            (self::MEAL !== $slots['type'] && self::TRAINING !== $slots ['type'])) {
            throw new Exception("Type must be defined with MEAL or TRAINING value");
        }
        return $slots['type'] === self::MEAL
            ? SlotMeal::createCollection($user, $slots)
            : SlotTraining::createCollection($user, $slots);
    }

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt->format('H:i');
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->endAt->format('H:i');
    }

    abstract function getType(): string;
}
