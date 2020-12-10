<?php

namespace App\Utils;

class Number
{

    public static function findTwoValueThatSumEqual(int $value, array $list): array
    {
        $items = $list;
        $item2 = null;

        //var_dump($items);
        do {
            $item1 = array_shift($items);

            foreach ($items as $item) {
                if (($item1 + $item) == $value) {
                    $item2 = $item;
                    break;
                }
            }

        } while (count($items) && ($item1 + $item2) !== $value);

        return [$item1, $item2];
    }

    public static function findContiguousValueThatSumEqual(int $value, array $inputs, int $from=0, ?int $to=null): ?array
    {
        $list = $inputs;
        $start_index = $from;

        if(is_null($to))
        {
            $to = count($list);
        }

        do {

            $items = [];
            for($i=$start_index; $i<$to; $i++)
            {
                $items[] = $list[$i];

                if(array_sum($items) === $value)
                {
                    return $items;
                }
            }

            $start_index++;
        }
        while($start_index < $to);

        return null;
    }
}