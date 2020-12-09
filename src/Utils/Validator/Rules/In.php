<?php

namespace App\Utils\Validator\Rules;

use App\Utils\Validator\Rule;

class In extends Rule
{
    public function validate(string $value, ?string $param=null)
    {
        $params = explode(",", $param);
        return in_array($value, $params);
    }
}