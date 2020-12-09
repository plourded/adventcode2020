<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class Height extends Rule
{
    public function validate(string $str_value, ?string $param = null)
    {
        if (str_ends_with($str_value, "cm")) {
            $value = intval(substr($str_value, 0, -2));

            return ($value >= 150) && ($value <= 193);
        } elseif (str_ends_with($str_value, "in")) {
            $value = intval(substr($str_value, 0, -2));

            return ($value >= 59) && ($value <= 76);
        }

        return false;
    }
}