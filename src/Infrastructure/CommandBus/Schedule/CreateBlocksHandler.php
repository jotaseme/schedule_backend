<?php

namespace App\Infrastructure\CommandBus\Schedule;

use App\Application\UseCase\CreateBlocksUseCase;
use App\Domain\Schedule\User;
use Exception;

class CreateBlocksHandler
{
    private CreateBlocksUseCase $useCase;

    /**
     * @param CreateBlocksUseCase $useCase
     */
    public function __construct(CreateBlocksUseCase $useCase)
    {
        $this->useCase = $useCase;
    }

    /**
     * @param CreateBlocksCommand $command
     * @return iterable
     * @throws Exception
     */
    public function handle(CreateBlocksCommand $command): iterable
    {
        return $this->useCase->execute($command->getEmail(), $command->getStartAt(), $command->getEndAt());
    }
}
