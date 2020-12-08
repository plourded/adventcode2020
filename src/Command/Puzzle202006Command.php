<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202006Command extends Command
{
    protected static $defaultName = 'solve:six2020';

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the sixth puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Six from 2020!');

        $input_file = new File("2020/6.txt");
        $customs_forms_for_all = $input_file->toArray();

        $group_index = 0;
        $group_customs = [];
        $group_persons = [];

        foreach ($customs_forms_for_all as $customs_forms_line) {

            if ($customs_forms_line === "") {
                $group_index++;
            } else {

                 if(!isset($group_persons[$group_index]))
                    $group_persons[$group_index] = [];

                $group_persons[$group_index][] = $customs_forms_line;

                for ($i=0; $i<strlen($customs_forms_line); $i++) {

                    if(isset($group_customs[$group_index][ $customs_forms_line[$i] ]))
                        $group_customs[$group_index][ $customs_forms_line[$i] ] += 1;
                    else
                        $group_customs[$group_index][ $customs_forms_line[$i] ] = 1;
                }

            }
        }

        //var_dump($group_customs);
        
        $response_a = array_reduce(
            $group_customs,
            function($carry, $group){
                return $carry + count($group);
            },
            0);

        $output->writeln("Puzzle A: My seat is $response_a" );

        $carry = 0;
        foreach ($group_customs as $group_index => $group_custom)
        {
            foreach ($group_custom as $item)
            {
                if( $item === count($group_persons[$group_index]) )
                {
                    $carry += 1;
                }
            }
        }
        $output->writeln("Puzzle B: My seat is $carry" );

        return Command::SUCCESS;
    }
}