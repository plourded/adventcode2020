<?php

namespace App\Command;

use http\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle201901Command extends Command
{
    protected const INPUTS = [
            82406,
            83106,
            120258,
            142695,
            50629,
            117793,
            81165,
            83442,
            70666,
            94355,
            64069,
            72830,
            88813,
            148762,
            90723,
            121206,
            57713,
            116892,
            82470,
            101686,
            83768,
            92160,
            91532,
            136997,
            142382,
            120050,
            81062,
            106227,
            112071,
            102275,
            54033,
            109059,
            91772,
            63320,
            81872,
            52925,
            92225,
            60053,
            110402,
            97125,
            87404,
            54970,
            66662,
            83979,
            88474,
            91361,
            69272,
            61559,
            56603,
            96324,
            66226,
            95278,
            105643,
            139141,
            116838,
            130717,
            97708,
            108371,
            73652,
            100518,
            98295,
            63127,
            50486,
            121157,
            109721,
            110874,
            124791,
            147116,
            127335,
            65889,
            76769,
            100596,
            79740,
            125860,
            120185,
            73861,
            97700,
            147169,
            106781,
            71891,
            64744,
            107113,
            59274,
            77680,
            101891,
            69848,
            98922,
            147825,
            128315,
            55221,
            119892,
            87492,
            75814,
            80350,
            131504,
            81095,
            57344,
            63765,
            143915,
            126768,
        ];

    protected static $defaultName = 'solve:one2019';

    protected function configure()
    {
        $this
            // the short description shown while running "php bin/console list"
            ->setDescription('Run AdventOfCode Puzzle solver.')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('This command allows you solve the first puzzle of AdventOfCode from 2019');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle One from 2019!');

        $sum = 0;
        foreach (self::INPUTS as $mass)
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

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;
    }

    protected function getFuel(float $mass): int
    {
        return intval(floor($mass / 3.0)) - 2;
    }
}