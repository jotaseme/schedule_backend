<?php

namespace App\Infrastructure\CommandBus\Schedule;


class CreateSlotsCommand
{
    private ?string $slots;

    /**
     * @param string|null $slots
     */
    public function __construct(?string $slots)
    {
        $this->slots = $slots;
    }

    /**
     * @return string|null
     */
    public function getSlots(): ?string
    {
        return $this->slots;
    }
}
