<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class HexadecimalColor extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        return preg_match("/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/", $value);
    }
}