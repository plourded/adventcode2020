<?php

namespace App\Command;

use App\Utils\File;
use App\Utils\Graph\Graph;
use App\Utils\Graph\Link;
use App\Utils\Graph\Node;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202007Command extends Command
{
    protected static $defaultName = 'solve:2020puzzle7';

    protected Graph $graph;

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the seventh puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Seven from 2020!');

        $input_file = new File("2020/7.txt");
        $rules = $input_file->toArray();

        $this->graph = new Graph();

        foreach ($rules as $rule_text) {

            [$containers, $contents_text] = explode(" contain ", $rule_text);

            $contents = explode(",", $contents_text);
            $containers = str_replace("bags", "", $containers);
            $containers = str_replace("bag", "", $containers);
            $containers = str_replace(".", "", $containers);
            $container_color = trim($containers);

            $container_node = $this->graph->firstOrCreateNode($container_color);

            foreach ($contents as $link)
            {
                if($link === "no other bags.")
                    break;

                [$qty, $c1, $c2, $bag] = explode(" ", trim($link));

                $link_node = $this->graph->firstOrCreateNode("$c1 $c2");

                $this->graph->addLink($container_node, $link_node, $qty);
            }
        }

        $parents = $this->graph->findRecursiveParentForNode("shiny gold");

        $output->writeln("Puzzle A: their is " . count($parents) . " container for Shiny Gold bags" );

        $child_bags_count = $this->graph->countChildren("shiny gold");

        $output->writeln("Puzzle B: " . $child_bags_count . " individual bags are required inside your single Shiny Gold bags" );

        return Command::SUCCESS;
    }


}