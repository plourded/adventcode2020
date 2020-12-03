<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202002Command extends Command
{
    protected static $defaultName = 'solve:two2020';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the second puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Two from 2020!');

        $input_file = new File("2020/2.txt");

        $passwords = $input_file->toArray();

        $valid_password_a = [];
        $valid_password_b = [];

        foreach ($passwords as $rule_and_password)
        {
            preg_match("/(\\d+)-(\\d+) ([a-z]): ([a-z]+)/", $rule_and_password, $matches);
            [, $min, $max, $char, $password] = $matches;

            $count = substr_count($password, $char);
            if( $count >= intval($min) && $count <= intval($max) )
            {
                $valid_password_a[] = $password;
            }

            $count = $password[$min-1] === $char ? 1 : 0;
            $count += $password[$max-1] === $char ? 1 : 0;
            if($count === 1)
            {
                $valid_password_b[] = $password;
            }
        }

        $output->writeln("Puzzle A: There is " . count($valid_password_a) . " valid passwords.");

        $output->writeln("Puzzle B: There is " . count($valid_password_b) . " valid passwords.");

        return Command::SUCCESS;
    }
}