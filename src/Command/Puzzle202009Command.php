<?php

namespace App\Command;

use App\Utils\File;
use App\Utils\Graph\Graph;
use App\Utils\Graph\Link;
use App\Utils\Graph\Node;
use App\Utils\Number;
use App\Utils\Program\Accumulator;
use App\Utils\Program\InstructionStack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202009Command extends Command
{
    protected static $defaultName = 'solve:2020puzzle9';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the ninth puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle nine from 2020!');

        $input_file = new File("2020/9.txt");
        $input_lines = $input_file->toArray();

        $preamble_size = 25;
        $current_index = $preamble_size;
        do
        {
            $preamble = [];
            for($i=$current_index-$preamble_size; $i<$current_index; $i++)
            {
                $preamble[] = $input_lines[$i];
                //var_dump("preamble " . count($preamble));
            }

            $current_value = $input_lines[$current_index];
            var_dump("current_value: $current_value");

            [$item1, $item2] = Number::findTwoValueThatSumEqual($current_value, $preamble);

            var_dump($item1, $item2);

            if( is_null($item2) )
            {
                $contiguous = Number::findContiguousValueThatSumEqual($current_value, $input_lines, 0, $current_index);

                if( !is_null($contiguous) )
                {
                    sort($contiguous);
                    var_dump($contiguous);

                    var_dump($contiguous[0] + $contiguous[count($contiguous)-1]);
                }
                break;
            }

            $current_index++;

        }
        while($current_index < count($input_lines));

        return Command::SUCCESS;
    }


}