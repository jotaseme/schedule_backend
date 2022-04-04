<?php

namespace App\Infrastructure\CommandBus\Schedule;


class GetBlocksCommand
{
    private ?string $from;
    private ?string $to;

    /**
     * @param string|null $from
     * @param string|null $to
     */
    public function __construct(?string $from, ?string $to)
    {
        $this->from = $from;
        $this->to   = $to;
    }

    /**
     * @return string|null
     */
    public function getFrom(): ?string
    {
        return $this->from;
    }

    /**
     * @return string|null
     */
    public function getTo(): ?string
    {
        return $this->to;
    }
}
