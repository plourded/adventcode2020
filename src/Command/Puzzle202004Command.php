<?php

namespace App\Command;

use App\Utils\File;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Puzzle202004Command extends Command
{
    protected static $defaultName = 'solve:four2020';

    protected array $required_rules;

    public function __construct(string $name = null)
    {
        parent::__construct($name);

        $this->required_rules = [
            // (Birth Year)
            "byr" => function (string $str_value): bool {
                if (strlen($str_value) !== 4)
                    return false;

                $date = intval($str_value);
                return ($date >= 1920) && ($date <= 2002);
            },

            // (Issue Year)
            "iyr" => function (string $str_value): bool {
                if (strlen($str_value) !== 4)
                    return false;

                $date = intval($str_value);
                return ($date >= 2010) && ($date <= 2020);
            },

            // (Expiration Year)
            "eyr" => function (string $str_value): bool {
                if (strlen($str_value) !== 4)
                    return false;

                $date = intval($str_value);
                return ($date >= 2020) && ($date <= 2030);
            },

            // (Height)
            "hgt" => function (string $str_value): bool {
                if (str_ends_with($str_value, "cm")) {
                    $value = intval(substr($str_value, 0, -2));

                    return ($value >= 150) && ($value <= 193);
                } elseif (str_ends_with($str_value, "in")) {
                    $value = intval(substr($str_value, 0, -2));

                    return ($value >= 59) && ($value <= 76);
                }

                return false;
            },

            // (Hair Color)
            "hcl" => function (string $str_value): bool {

                return preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $str_value);
            },

            // (Eye Color)
            "ecl" => function (string $str_value): bool {
                return in_array($str_value, ["amb", "blu", "brn", "gry", "grn", "hzl", "oth"]);
            },

            // (Passport ID)
            "pid" => function (string $str_value): bool {
                if (strlen($str_value) !== 9)
                    return false;

                return is_numeric($str_value);
            },

            "cid" => function (string $str_value): bool {
                return true;
            },
        ];
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

        $passports = [];
        foreach ($passports_items as $index => $passport_items) {
            $passport = [];
            foreach ($passport_items as $item) {
                [$key, $value] = explode(":", $item);

                if (isset($passport[$key]) && $key === "ecl") {
                    $passport[$key]["is_valid"] = false;
                } else {
                    $passport[$key] = ["value" => $value, "is_valid" => $this->required_rules[$key]($value)];
                }
            }

            if(!isset($passport["cid"]))
            {
                $passport["cid"] = ["value" => "", "is_valid" => true];
            }

            $passports[] = $passport;
        }

        $valid_passports = [];
        foreach ($passports as $passport) {
            if ($this->validate_passport($passport)) {
                $valid_passports[] = $passport;
            }
        }

        $output->writeln("Puzzle A: There is " . count($valid_passports) . " valid passports");

        return Command::SUCCESS;
    }

    protected function validate_passport(array $passport): bool
    {
        foreach ($this->required_rules as $key => $validator) {
            if ((!array_key_exists($key, $passport)) || (!$passport[$key]["is_valid"]) ) {
                //var_dump($passport);
                return false;
            }
        }
        return true;
    }
}