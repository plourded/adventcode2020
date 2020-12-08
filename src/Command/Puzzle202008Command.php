<?php

namespace App\Command;

use App\Utils\File;
use App\Utils\Graph\Graph;
use App\Utils\Graph\Link;
use App\Utils\Graph\Node;
use App\Utils\Program\Accumulator;
use App\Utils\Program\InstructionStack;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202008Command extends Command
{
    protected static $defaultName = 'solve:2020puzzle8';

    protected InstructionStack $stack;

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the eighth puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle eight from 2020!');

        $input_file = new File("2020/8.txt");
        $code_lines = $input_file->toArray();

        $this->stack = new InstructionStack();

        foreach ($code_lines as $code_line) {
            [$instruction, $parameter] = explode(" ", $code_line);
            $parameter = intval( $parameter);

            $this->stack->addInstruction($instruction, $parameter);
        }

        try {
            while(true)
            {
                $this->stack->run();
            }
        }
        catch (\Exception $e)
        {
            var_dump($e->getMessage());
        }



        return Command::SUCCESS;
    }


}