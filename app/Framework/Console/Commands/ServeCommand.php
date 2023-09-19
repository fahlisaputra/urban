<?php

namespace App\Framework\Console\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class ServeCommand extends Command
{
    protected $commandName = 'serve';
    protected $commandDescription = "Serve the application on the PHP development server";

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $command = 'php -S localhost:8000 -t public';
        $output->writeln([
            '',
            '<fg=green;options=bold;>Starting Urban Development Server</>'
        ]);
        exec($command);
    }
}
