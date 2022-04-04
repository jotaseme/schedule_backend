<?php

namespace App\Infrastructure\Command;

use App\Infrastructure\CommandBus\Schedule\CreateBlocksCommand;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class GenerateUserCalendarCommand
 * @package App\Infrastructure\Command
 */
class GenerateUserBlocksCommand extends Command
{
    private CommandBus $commandBus;

    /**
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('app:generate:user:blocks')
            ->setDescription('Genera los bloques del calendario para el usuario indicando dos fechas.')
            ->setHelp(
                <<<EOT
                    El comando <info>app:generate:user:blocks</info> 
                    genera los bloques del calendario para el usuario indicando dos fechas.
                    EOT
            );
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $email   = $io->ask('Email usuario');
        $startAt = $io->ask('Fecha inicio del programa');
        $endAt   = $io->ask('Fecha fin del programa');

        $command = new CreateBlocksCommand($email, $startAt, $endAt);
        $this->commandBus->handle($command);

        $io->success("Bloques del calendario para usuario con email " . $email . " creados.");

        return 0;
    }
}

