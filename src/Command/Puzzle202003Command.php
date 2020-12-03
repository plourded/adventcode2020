<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202003Command extends Command
{
    protected static $defaultName = 'solve:three2020';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the third puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Three from 2020!');

        $input_file = new File("2020/3.txt");
        $map_rows = $input_file->toArray();

        $height = count($map_rows);
        $trees = [
            0,0,0,0,0
        ];
        $slopes = [
            [ "x" => 1, "y" => 1],
            [ "x" => 3, "y" => 1],
            [ "x" => 5, "y" => 1],
            [ "x" => 7, "y" => 1],
            [ "x" => 1, "y" => 2],
        ];

        foreach ($slopes as $index => $slope) {

            $actual_row = 0;
            $actual_col = 0;

            while ($actual_row < $height) {
                //$output->writeln("line $actual_row over " . $height);

                while ($actual_col >= strlen($map_rows[$actual_row])) {
                    $map_rows[$actual_row] .= $map_rows[$actual_row];
                }

                if ($map_rows[$actual_row][$actual_col] === "#") {
                    $trees[$index] += 1;
                }

                $actual_row += $slope["y"];
                $actual_col += $slope["x"];
            }
        }

        $tree_count = array_reduce($trees, function($carry, $item){
            return $carry*$item;
        }, 1);

        $output->writeln("Puzzle A: There is ".$trees[1]." tree");
        $output->writeln("Puzzle B: There is $tree_count tree");

        return Command::SUCCESS;
    }
}