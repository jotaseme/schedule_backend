<?php

namespace App\Infrastructure\CommandBus\Schedule;

use App\Application\UseCase\CreateScheduleUseCase;
use App\Application\UseCase\GetBlocksUseCase;
use App\Domain\Schedule\User;
use Exception;

class GetBlocksHandler
{
    private GetBlocksUseCase $useCase;

    /**
     * @param GetBlocksUseCase $useCase
     */
    public function __construct(GetBlocksUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param GetBlocksCommand $command
     * @return iterable
     */
    public function handle(GetBlocksCommand $command): iterable
    {
        return $this->useCase->execute($command->getFrom(), $command->getTo());
    }
}
