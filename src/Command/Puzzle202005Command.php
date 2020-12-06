<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202005Command extends Command
{
    protected static $defaultName = 'solve:five2020';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the fifth puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Five from 2020!');

        $input_file = new File("2020/5.txt");
        $boardings_passes = $input_file->toArray();
        $seat_ids = [];

        foreach ($boardings_passes as $boardings_pass)
        {
            $row_min = 0;
            $row_max = 127;

            for ($i=0; $i<7; $i++) {
                if($boardings_pass[$i] === "F")
                {
                    $row_max -= ceil( ($row_max - $row_min) / 2.0);
                }
                elseif($boardings_pass[$i] === "B")
                {
                    $row_min += ceil( ($row_max - $row_min) / 2.0);
                }
            }

            $row = $row_min;

            $col_min = 0;
            $col_max = 7;
            for ($i=7; $i<10; $i++) {
                if($boardings_pass[$i] === "L")
                {
                    $col_max -= ceil( ($col_max - $col_min) / 2.0);
                }
                elseif($boardings_pass[$i] === "R")
                {
                    $col_min += ceil( ($col_max - $col_min) / 2.0);
                }
            }

            $col = $col_min;
            $seat_id = $row*8 + $col;

            $seat_ids[] = $seat_id;
        }

        rsort($seat_ids);

        $output->writeln("Puzzle A: The maximum seat id is " . $seat_ids[0]);

        $seat = null;
        for($i=1; $i<$seat_ids[0]-1; $i++)
        {
            if( ($seat_ids[$i-1] - 1) !== $seat_ids[$i] )
            {
                $seat = $seat_ids[$i-1] - 1;
                break;
            }
        }

        $output->writeln("Puzzle B: My seat is " . $seat);

        return Command::SUCCESS;
    }
}