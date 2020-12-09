<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class StrLength extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        return strlen($value) === intval($param);
    }
}