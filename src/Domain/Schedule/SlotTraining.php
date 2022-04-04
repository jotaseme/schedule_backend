<?php

namespace App\Domain\Schedule;

use DateTime;
use DateTimeInterface;
use Exception;
use JetBrains\PhpStorm\Pure;

class SlotTraining extends Slot
{
    private string $day;

    /**
     * @param User $user
     * @param DateTimeInterface $startAt
     * @param DateTimeInterface $endAt
     * @param string $day
     */
    #[Pure] protected function __construct(
        User $user, DateTimeInterface $startAt, DateTimeInterface $endAt, string $day
    )
    {
        parent::__construct($user, $startAt, $endAt);
        $this->day = $day;
    }

    /**
     * @param User $user
     * @param array|null $slots
     * @return array
     * @throws Exception
     */
    public static function createCollection(User $user, ?array $slots): array
    {
        $collection = [];
        if (!array_key_exists('items', $slots)) {
            throw new Exception("Only 3, 5, or 7 meals can be defined");
        }

        foreach ($slots['items'] as $slot) {
            if (!array_key_exists('day', $slot)
                || !in_array($slot['day'], self::DAYS)) {
                throw new Exception("Values allowed for event: " . implode(',', self::DAYS));
            }
            if (!array_key_exists('startAt', $slot) || null == date('H:i', strtotime($slot['startAt']))) {
                throw new Exception("Invalid Start Date");
            }
            if (!array_key_exists('endAt', $slot) || null == date('H:i', strtotime($slot['endAt']))) {
                throw new Exception("Invalid End Date");
            }
            $collection[] = new self(
                $user, DateTime::createFromFormat('H:i', $slot['startAt']),
                DateTime::createFromFormat('H:i', $slot['startAt']), $slot['day']
            );

        }
        return $collection;
    }

    /**
     * @return string
     */
    public function getDay(): string
    {
        return $this->day;
    }

    /**
     * @return string
     */
    function getType(): string
    {
        return self::TRAINING;
    }
}
