<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class Numeric extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        return is_numeric($value);
    }
}