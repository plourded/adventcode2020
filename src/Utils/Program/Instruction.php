<?php

namespace App\Utils\Program;

class Instruction
{
    public string $name;
    public ?int $parameter;
    public bool $has_run = false;

    public function __construct(string $name, ?int $parameter=null)
    {
        $this->name = $name;
        $this->parameter = $parameter;
    }
}