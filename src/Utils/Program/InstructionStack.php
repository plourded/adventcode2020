<?php

namespace App\Utils\Program;

/**
 * Class InstructionStack
 * @package App\Utils\Program
 */
class InstructionStack
{
    protected array $instructions;
    protected array $call_stack = [];
    protected ?int $auto_fixed_instruction_index = null;

    protected int $instruction_index = 0;
    protected Accumulator $accumulator;

    public function __construct(array $instructions = [])
    {
        $this->instructions = $instructions;
        $this->accumulator = new Accumulator(0);
    }

    public function addInstruction(string $name, ?int $parameter = null): void
    {
        $this->instructions[] = new Instruction($name, $parameter);
    }

    public function run()
    {
        if (!isset($this->instructions[$this->instruction_index])) {
            //TODO: can be different than a valid end of program.
            throw new \Exception("Out of stack, accumulator: " . $this->accumulator->value);
        }

        $current_instruction = $this->instructions[$this->instruction_index];

        if ($current_instruction->has_run) {
            if ($this->auto_fixed_instruction_index) {
                do {
                    if ($this->auto_fixed_instruction_index === $this->instruction_index) {
                        $this->auto_fixed_instruction_index = null;
                    }
                    $this->backtrack();
                } while (!is_null($this->auto_fixed_instruction_index));
            }

            do {
                $this->backtrack();

                $current_instruction = $this->instructions[$this->instruction_index];
            } while (($current_instruction->name !== "jmp" &&
                $current_instruction->name !== "nop") ||
            !is_null($this->auto_fixed_instruction_index));

            //autofix
            $this->autofix($current_instruction);
            //throw new \Exception("Infinite Loop, accumulator: " . $this->accumulator->value);
        }

        $this->call_stack[] = [
            "instruction_index" => $this->instruction_index,
            "accumulator_state" => $this->accumulator->value,
        ];

        switch ($current_instruction->name) {
            case "acc":
                $this->accumulator->increment($current_instruction->parameter);
                $this->instruction_index += 1;
                break;

            case "jmp":
                $this->instruction_index += $current_instruction->parameter;
                break;

            case "nop":
                $this->instruction_index += 1;
                break;

            default:
                throw new \Exception("Unknown Instruction " . $current_instruction->name);
                break;
        }

        $current_instruction->has_run = true;
    }

    protected function backtrack(): void
    {
        if (!count($this->call_stack)) {
            throw new \Exception("Infinite Loop, call stack empty, cannot backtrack");
        }

        $backtrack_instruction = array_pop($this->call_stack);
        $this->accumulator->set($backtrack_instruction["accumulator_state"]);
        $this->instructions[$this->instruction_index]->has_run = false;
        $this->instruction_index = $backtrack_instruction["instruction_index"];
    }

    protected function autofix($current_instruction)
    {
        $this->auto_fixed_instruction_index = $this->instruction_index;
        if ($current_instruction->name === "jmp") {
            $current_instruction->name = "nop";
        } elseif ($current_instruction->name === "nop") {
            $current_instruction->name = "jmp";
        } else {
            throw new \Exception("Cant fix that kind of instruction");
        }

    }
}