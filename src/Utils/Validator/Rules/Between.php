<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class Between extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        [$min, $max] = explode(",", $param);

        return (intval($value) >= intval($min)) &&
               (intval($value) <= intval($max));
    }
}