<?php

namespace App\Command;

use App\Utils\File;
use App\Utils\Number;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202001Command extends Command
{
    protected static $defaultName = 'solve:one2020';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the first puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle One from 2020!');

        $input_file = new File("2020/1.txt");

        $account_items = $input_file->toArray();

        [$item1, $item2] = Number::findTwoValueThatSumEqual(2020, $account_items);

        $output->writeln('Item 1: ' . $item1 . " and item 2: " . $item2);
        $output->writeln('Puzzle 1A response: ' . ($item1 * $item2));

        $account_items = $input_file->toArray();;
        $item3 = 0;

        do {
            $temp_items = [];
            $item1 = array_shift($account_items);

            do {
                $item2 = array_shift($account_items);
                $temp_items[] = $item2;

                if (($item1 + $item2) < 2020) {
                    foreach ($account_items as $acount_item2) {
                        if (($item1 + $item2 + $acount_item2) === 2020) {
                            $item3 = $acount_item2;
                            break;
                        }
                    }
                }

            } while (count($account_items) && ($item3===0));

            $account_items = $temp_items;

        } while (($item1 + $item2 + $item3) !== 2020 || !count($account_items));

        $output->writeln('Item 1: ' . $item1 . " and item 2: " . $item2 . " and item 3: " . $item3);
        $output->writeln('Puzzle 1B response: ' . ($item1 * $item2 * $item3));

        return Command::SUCCESS;
    }
}