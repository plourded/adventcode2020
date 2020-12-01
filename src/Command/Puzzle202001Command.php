<?php

namespace App\Command;

use http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202001Command extends Command
{
    protected const INPUTS = [

    ];

    protected static $defaultName = 'solve:one2020';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Run AdventOfCode Puzzle solver.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you solve the first puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle One from 2020!');

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;
    }
}