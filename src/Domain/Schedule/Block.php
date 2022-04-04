<?php

namespace App\Domain\Schedule;

use DateInterval;
use DatePeriod;
use DateTime;
use DateTimeInterface;
use JetBrains\PhpStorm\Pure;

class Block
{
    private int               $id;
    private string            $type;
    private string            $startAt;
    private string            $endAt;
    private DateTimeInterface $date;
    private User              $user;
    private bool              $optional;

    /**
     * @param string $type
     * @param string $startAt
     * @param string $endAt
     * @param DateTimeInterface $date
     * @param User $user
     * @param bool $optional
     */
    public function __construct(
        string $type, string $startAt, string $endAt, DateTimeInterface $date, User $user, bool $optional
    )
    {
        $this->type     = $type;
        $this->startAt  = $startAt;
        $this->endAt    = $endAt;
        $this->date     = $date;
        $this->user     = $user;
        $this->optional = $optional;
    }

    #[Pure] private static function create(
        string $type, string $startAt, string $endAt, DateTimeInterface $date, User $user, bool $optional
    ): self
    {
        return new self($type, $startAt, $endAt, $date, $user, $optional);
    }

    /**
     * @param User $user
     * @param string|null $from
     * @param string|null $to
     * @return iterable<Block>
     */
    public static function createCollection(User $user, ?string $from, ?string $to): iterable
    {
        $collection = [];
        $days       = new DatePeriod(
            DateTime::createFromFormat('Y/m/d', $from),
            DateInterval::createFromDateString('1 day'),
            DateTime::createFromFormat('Y/m/d', $to)
        );

        foreach ($days as $day) {
            $currentDay = $day->format("l");
            foreach ($user->getSlots() as $slot) {
                if ($slot instanceof SlotMeal) {
                    $collection[] = self::create(
                        $slot->getType(), $slot->getStartAt(), $slot->getEndAt(), $day, $user,
                        $slot->getExclude() === $currentDay
                    );
                }
                if ($slot instanceof SlotTraining && $currentDay === $slot->getDay()) {
                    $collection[] = self::create(
                        $slot->getType(), $slot->getStartAt(), $slot->getEndAt(), $day, $user, false
                    );
                }
            }
        }
        return $collection;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getStartAt(): string
    {
        return $this->startAt;
    }

    /**
     * @return string
     */
    public function getEndAt(): string
    {
        return $this->endAt;
    }

    /**
     * @return DateTimeInterface
     */
    public function getDate(): DateTimeInterface
    {
        return $this->date;
    }
}
