<?php

namespace App\Domain\Schedule;

use App\Domain\AggregateRoot;
use App\Domain\Schedule\Event\SlotsAddedEvent;
use App\Domain\Schedule\Event\UserCreatedEvent;
use DateTime;

class User extends AggregateRoot
{
    protected string $id;

    protected string $email;

    protected iterable $slots;

    protected iterable $blocks;

    /**
     * @param string $email
     */
    public function __construct(string $email)
    {
        $this->email = $email;
    }

    /**
     * @param string $email
     * @return static
     */
    public static function create(string $email): self
    {
        $user = new static($email);
        $user->record(new UserCreatedEvent($user, new DateTime()));

        return $user;
    }

    /**
     * @param iterable<Slot> $slots
     * @return static
     */
    public function addSlots(iterable $slots): self
    {
        $this->slots = $slots;
        $this->record(new SlotsAddedEvent(new DateTime()));

        return $this;
    }

    /**
     * @param iterable<Block> $blocks
     * @return static
     */
    public function addBlocks(iterable $blocks): self
    {
        $this->blocks = $blocks;
        $this->record(new SlotsAddedEvent(new DateTime()));

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return iterable<Slot>
     */
    public function getSlots(): iterable
    {
        return $this->slots;
    }

    /**
     * @return iterable
     */
    public function getBlocks(): iterable
    {
        return $this->blocks;
    }
}
