<?php

namespace App\Utils\Program;

class Accumulator
{
    public int $value;

    public function __construct(int $value)
    {
        $this->value = $value;
    }

    public function set(int $value)
    {
        $this->value = $value;
    }

    public function increment(int $value)
    {
        $this->value += $value;
    }
}