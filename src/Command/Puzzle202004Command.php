<?php

namespace App\Command;

use App\Utils\File;
use App\Utils\Validator\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202004Command extends Command
{
    protected static $defaultName = 'solve:four2020';

    public function __construct(string $name = null)
    {
        parent::__construct($name);
    }

    protected function configure()
    {
        $this
            ->setDescription('Run AdventOfCode Puzzle solver.')
            ->setHelp('This command allows you solve the forth puzzle of AdventOfCode from 2020');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Solving puzzle Four from 2020!');

        $input_file = new File("2020/4.txt");
        $passports_lines = $input_file->toArray();

        $passport_index = 0;
        $passports_items = [];

        foreach ($passports_lines as $passports_line) {
            if ($passports_line === "") {
                $passport_index++;
            } else {
                $elements = explode(" ", $passports_line);

                if (!isset($passports_items[$passport_index])) {
                    $passports_items[$passport_index] = [];
                }

                $passports_items[$passport_index] = array_merge($elements, $passports_items[$passport_index]);
            }
        }

        $validator = new Validator([
            "byr" => "require|len:4|between:1920,2002",
            "iyr" => "require|len:4|between:2010,2020",
            "eyr" => "require|len:4|between:2020,2030",
            "hgt" => "require|height",
            "hcl" => "require|hex_color",
            "ecl" => "require|in:amb,blu,brn,gry,grn,hzl,oth", //once
            "pid" => "require|len:9|numeric",
            "cid" => "optional",
        ]);

        $valid_passports = [];
        foreach ($passports_items as $index => $passport_items) {
            $passport = [];
            foreach ($passport_items as $item) {
                [$key, $value] = explode(":", $item);

                if (isset($passport[$key]) && $key === "ecl") {
                    $passport[$key] = null; //once patch
                } else {
                    $passport[$key] = $value;
                }
            }

            if( $validator->validate($passport) )
            {
                $valid_passports[] = $passport;
            }

        }

        $output->writeln("Puzzle A: There is " . count($valid_passports) . " valid passports");

        return Command::SUCCESS;
    }
}