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

    public static function puzzle_2024_2_1(string $input): int {
        $data = explode(PHP_EOL, trim($input));
        $data = array_map(fn (string $report) => explode(' ', $report), $data);

        $totalSafe = 0;

        foreach ($data as $report) {
            $growth = $report[1] > $report[0];
            $safe = true;
            for ($i = 1; $i < count($report); $i++) {
                //is growth the same as starting out
                if (($report[$i] > $report[$i-1]) !== $growth) {
                    $safe = false;
                    break;
                }
                $diff = abs($report[$i] - $report[$i-1]);
                if ($diff < 1 || $diff > 3) {
                    $safe = false;
                    break;
                }
            }
            $totalSafe += $safe ? 1 : 0;
        }

        return $totalSafe;
    }
    public static function puzzle_2024_2_2(string $input): int {
        $data = explode(PHP_EOL, trim($input));
        $data = array_map(fn (string $report) => explode(' ', $report), $data);

        $totalSafe = 0;

        foreach ($data as $report) {
            if (self::isReportSafe($report)) {
                $totalSafe++;
                continue;
            }

            for ($i = 0; $i < count($report); $i++) {
                $temp = $report;
                array_splice($report, $i, 1);

                if (self::isReportSafe($report)) {
                    $totalSafe++;
                    continue 2;
                }

                $report = $temp;
            }
        }

        return $totalSafe;
    }

    //report is safe when both of the conditions are true :
    ////it's values increase or deacrease throughout e.g. 1 3 5 or 8 6 3
    //difference between elements must be in {1, 2, 3} set
    public static function isReportSafe(array $report): bool {
        if (!self::isArraySorted($report)) {
            return false;
        }
        if (!self::areArrayIncrementsSafe($report)) {
            return false;
        }

        return true;
    }

    //this considers 2, 3, 3, 4 unsorted
    public static function isArraySorted(array $array): bool {
        $signSum = 0;

        for ($i = 0; $i < count($array) - 1; $i++) {
            $signSum += self::sign($array[$i+1] - $array[$i]);
        }

        return abs($signSum) === count($array) - 1;
    }

    public static function sign(int $number): int {
        return ($number > 0) - ($number < 0);
    }

    public static function areArrayIncrementsSafe(array $array): bool {
        $safe = 0;

        for($i = 0; $i < count($array) - 1; $i++) {
            $diff = abs($array[$i+1] - $array[$i]);
            if ($diff > 3 || $diff < 1) {
                return false;
            }
        }
        return true;
    }

    public static function puzzle_2024_3_1(string $input): int {
        $mults = [];
        $multsNo = preg_match_all('/mul\([0-9]+\,[0-9]+\)/', $input, $mults);

        $finalSum = 0;

        foreach ($mults[0] as $mult) {
            $nums = [];
            preg_match_all('/[0-9]+/', $mult, $nums);
            $finalSum += $nums[0][0] * $nums[0][1];
        }

        return $finalSum;
    }

    public static function puzzle_2024_3_2(string $input): int
    {
        $commands = [];
        $commandsNo = preg_match_all('/mul\([0-9]+\,[0-9]+\)|do\(\)|don\'t\(\)/', $input, $commands);

        $finalSum = 0;
        $multEnabled = true;

        foreach ($commands[0] as $command) {
            switch ($command) {
                case 'do()':
                    $multEnabled = true;
                    break;
                case 'don\'t()':
                    $multEnabled = false;
                    break;
                default:
                    if ($multEnabled) {
                        $mult = [];
                        preg_match_all('/[0-9]+/', $command, $mult);
                        $finalSum += $mult[0][0] * $mult[0][1];
                    }
                    break;
            }
        }

        return $finalSum;
    }
}

