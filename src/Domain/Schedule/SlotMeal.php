<?php

namespace App\Domain\Schedule;

use DateTime;
use DateTimeInterface;
use Exception;
use JetBrains\PhpStorm\Pure;

class SlotMeal extends Slot
{
    const MEAL1 = 'MEAL1';
    const MEAL2 = 'MEAL2';
    const MEAL3 = 'MEAL3';
    const MEAL4 = 'MEAL4';
    const MEAL5 = 'MEAL5';
    const MEAL6 = 'MEAL6';
    const MEAL7 = 'MEAL7';

    const ALLOWED_EVENTS = [self::MEAL1, self::MEAL2, self::MEAL3, self::MEAL4, self::MEAL5, self::MEAL6, self::MEAL7];

    private string  $event;
    private ?string $exclude;

    /**
     * @param User $user
     * @param DateTimeInterface $startAt
     * @param DateTimeInterface $endAt
     * @param string $event
     * @param string|null $exclude
     *
     */
    #[Pure] protected function __construct(
        User $user, DateTimeInterface $startAt, DateTimeInterface $endAt, string $event, ?string $exclude
    )
    {
        parent::__construct($user, $startAt, $endAt);
        $this->event   = $event;
        $this->exclude = $exclude;
    }

    /**
     * @param User $user
     * @param $slots
     * @return array
     * @throws Exception
     */
    public static function createCollection(User $user, $slots): array
    {
        $collection = [];
        if (!array_key_exists('items', $slots)
            || (count($slots['items']) !== 3 && count($slots['items']) !== 5 && count($slots['items']) !== 7)) {
            throw new Exception("Only 3, 5, or 7 meals can be defined");
        }

        foreach ($slots['items'] as $slot) {
            if (!array_key_exists('event', $slot)
                || !in_array($slot['event'], self::ALLOWED_EVENTS)) {
                throw new Exception("Values allowed for event: " . implode(',', self::ALLOWED_EVENTS));
            }
            if (!array_key_exists('startAt', $slot) || null == date('H:i', strtotime($slot['startAt']))) {
                throw new Exception("Invalid Start Date");
            }
            if (!array_key_exists('endAt', $slot) || null == date('H:i', strtotime($slot['endAt']))) {
                throw new Exception("Invalid End Date");
            }
            if (array_key_exists('exclude', $slot) && !in_array($slot['exclude'], self::DAYS)) {
                throw new Exception("Values allowed for exclude: " . implode(',', self::DAYS));
            }

            $collection[] = new self(
                $user, DateTime::createFromFormat('H:i', $slot['startAt']),
                DateTime::createFromFormat('H:i', $slot['endAt']), $slot['event'],
                array_key_exists('exclude', $slot) ? $slot['exclude'] : null
            );
        }

        return $collection;
    }

    /**
     * @return string
     */
    public function getEvent(): string
    {
        return $this->event;
    }

    /**
     * @return string|null
     */
    public function getExclude(): ?string
    {
        return $this->exclude;
    }

    /**
     * @return string
     */
    function getType(): string
    {
        return self::MEAL;
    }
}
