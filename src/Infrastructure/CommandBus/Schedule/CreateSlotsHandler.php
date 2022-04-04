<?php

namespace App\Infrastructure\CommandBus\Schedule;

use App\Application\UseCase\CreateSlotsUseCase;
use App\Domain\Schedule\User;
use Exception;

class CreateSlotsHandler
{
    private CreateSlotsUseCase $useCase;

    /**
     * @param CreateSlotsUseCase $useCase
     */
    public function __construct(CreateSlotsUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param CreateSlotsCommand $command
     * @return iterable
     * @throws Exception
     */
    public function handle(CreateSlotsCommand $command): iterable
    {
        return $this->useCase->execute($command->getSlots());
    }
}
