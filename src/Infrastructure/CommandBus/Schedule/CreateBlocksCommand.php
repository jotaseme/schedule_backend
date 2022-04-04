<?php

namespace App\Infrastructure\CommandBus\Schedule;


class CreateBlocksCommand
{
    private ?string $email;
    private ?string $startAt;
    private ?string $endAt;

    /**
     * @param string|null $email
     * @param string|null $startAt
     * @param string|null $endAt
     */
    public function __construct(?string $email, ?string $startAt, ?string $endAt)
    {
        $this->email   = $email;
        $this->startAt = $startAt;
        $this->endAt   = $endAt;
    }

    /**
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @return string|null
     */
    public function getStartAt(): ?string
    {
        return $this->startAt;
    }

    /**
     * @return string|null
     */
    public function getEndAt(): ?string
    {
        return $this->endAt;
    }
}
