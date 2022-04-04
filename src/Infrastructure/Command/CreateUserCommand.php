<?php

namespace App\Infrastructure\Command;

use App\Domain\Schedule\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * Class CreateUserCommand
 * @package App\Infrastructure\Command
 */
class CreateUserCommand extends Command
{
    private EntityManagerInterface $em;

    /**
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
        parent::__construct();
    }

    /**
     * @return void
     */
    protected function configure(): void
    {
        $this->setName('app:create:user')
            ->setDescription('Crear usuario indicando el email.')
            ->setHelp(
                <<<EOT
                    El comando <info>app:create:user</info> crea un usuario indicando el email.
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
        $io    = new SymfonyStyle($input, $output);
        $email = $io->ask('email');

        $this->em->persist(User::create($email));
        $this->em->flush();

        $io->success("Usuario con email " . $email . " creado.");

        return 0;
    }
}

