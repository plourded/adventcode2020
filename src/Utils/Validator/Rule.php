<?php

namespace App\Utils\Validator;

abstract class Rule
{
    public abstract function validate(string $value, ?string $param=null);
}