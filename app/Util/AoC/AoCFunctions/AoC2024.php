<?php

namespace App\Util\AoC\AoCFunctions;

class AoC2024
{
    public static function puzzle_2024_1_1(string $input): int {
        $data = explode(PHP_EOL, trim($input));

        //split data into left and right
        $data = array_map(fn(string $pair) => explode('   ', $pair), $data);

        //create arrays of left and right and sort them
        $left = [];
        $right = [];


        array_walk($data, function(array $pair) use (&$left, &$right) {
           $left[] = $pair[0];
           $right[] = $pair[1];
        });

        sort($left);
        sort($right);

        //calculate the final sum
        $sum = 0;

        foreach ($left as $key => $value) {
            $sum += abs($value - $right[$key]);
        }

        return $sum;
    }

    public static function puzzle_2024_1_2(string $input): int {
        $data = explode(PHP_EOL, trim($input));

        //split data into left and right
        $data = array_map(fn(string $pair) => explode('   ', $pair), $data);

        //create arrays of left and right
        $left = [];
        $right = [];

        array_walk($data, function (array $pair) use (&$left, &$right) {
           $left[] = $pair[0];
           $right[] = $pair[1];
        });

        //get only uniques from left and count right's number of occurences
        $left = array_unique($left);
        $rightOccurences = array_count_values($right);

       //calculate similarity by adding number's value times it's occurences in right list
        $similarity = 0;

        array_walk($left, function (int $number) use (&$similarity, $rightOccurences) {
            $similarity += ($rightOccurences[$number] ?? 0) * $number;
        });

        return $similarity;
    }
}
