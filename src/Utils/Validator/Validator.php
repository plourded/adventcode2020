<?php

namespace App\Utils\Validator;

class Validator
{
    protected array $rule_methods = [
        "min" => Rules\Min::class,
        "max" => Rules\Max::class,
        "between" => Rules\Between::class,
        "len" => Rules\StrLength::class,
        "numeric" => Rules\Numeric::class,
        "in" => Rules\In::class,
        "hex_color" => Rules\HexadecimalColor::class,
        "height" => Rules\Height::class,
    ];

    public array $errors = [];
    private array $rules;

    public function __construct(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate(array $values)
    {
        $pass = 0;
        foreach ($this->rules as $key => $validator_rules) {

            $rules = explode("|", $validator_rules);

            if($this->applyRuleForAField($rules, $key, $values))
                $pass += 1;
            else
                break;
        }

        return $pass === count($this->rules);
    }

    protected function applyRuleForAField($rules, $key, $values): bool
    {
        $pass = 0;
        foreach ($rules as $rule)
        {
            if( !$this->applySingleRule($rule, $key, $values) )
            {
                $this->errors[] = "$rule of $key failed";
                break;
            }
            else
            {
                $pass += 1;
            }
        }
        return $pass === count($rules);
    }

    protected function applySingleRule(string $rule, string $key, array $values): bool
    {
        if(str_contains($rule, ":"))
            [$rule, $params] = explode(":", $rule);

        switch ($rule)
        {
            case "require":
                return array_key_exists($key, $values) && !empty($values[$key]);

            case "optional":
                return true;

            default:
                $value = $values[$key];

                if( array_key_exists($rule, $this->rule_methods))
                {
                    return (new $this->rule_methods[$rule]())->validate($value, $params ?? null );
                }

                throw new \Exception("Unknown validation rule " . $rule);
        }
    }
}