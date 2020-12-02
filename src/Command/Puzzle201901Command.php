<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle201901Command extends Command
{
    protected static $defaultName = 'solve:one2019';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the first puzzle of AdventOfCode from 2019');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle One from 2019!');

        $input_data = (new File("2019/1.txt"))->toArray();
        $sum = 0;
        foreach ($input_data as $mass)
        {
            $fuel_requiered = $this->getFuel($mass);
            $sum += $fuel_requiered;

            while($fuel_requiered > 0)
            {
                $fuel_for_fuel = max(0, $this->getFuel($fuel_requiered));
                $sum += $fuel_for_fuel;
                $fuel_requiered = $fuel_for_fuel;
            }
        }

        $output->writeln('Total fuel: ' . $sum);

        return Command::SUCCESS;
    }

    protected function getFuel(float $mass): int
    {
        return intval(floor($mass / 3.0)) - 2;
    }
}