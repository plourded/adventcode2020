<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class Max extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        return intval($value) <= intval($param);
    }
}