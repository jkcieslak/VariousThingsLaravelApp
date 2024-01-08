<?php

namespace App\Util\AoC\AoCFunctions;

class AoC2023
{
    public static function puzzle_2023_1_1(string $input) : int {
        $totalValues = 0;
        $lines = explode(PHP_EOL, $input);
        foreach($lines as $line) {
            $numbers = [];
            if(!preg_match_all('/\d/', $line, $numbers)) {
                return $totalValues;
            }
            $totalValues += $numbers[0][0] * 10 + $numbers[0][count($numbers[0])-1];
        }
        return $totalValues;
    }

    public static function puzzle_2023_1_2(string $input) : int {
        $totalValue = 0;
        $lines = explode(PHP_EOL, $input);
        $digitNamesValues = ['zero' => 0, 'one' => 1, 'two' => 2, 'three' => 3, 'four' => 4, 'five' => 5, 'six' => 6,
            'seven' => 7, 'eight' => 8, 'nine' => 9];
        foreach($lines as $line) {
            $numbers = [];
            if(!preg_match_all('/(?=(one|two|three|four|five|six|seven|eight|nine|zero|\d))/', $line, $numbers)) {
                return $totalValue;
            }
            $firstNum = $numbers[1][0];
            $lastNum = $numbers[1][count($numbers[1])-1];
            $tensDigit = is_numeric($firstNum) ? $firstNum : $digitNamesValues[$firstNum];
            $onesDigit = is_numeric($lastNum) ? $lastNum : $digitNamesValues[$lastNum];
            $totalValue += $tensDigit * 10 + $onesDigit;
        }
        return $totalValue;
    }

    public static function puzzle_2023_2_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $possibleIds = [];
        $games = [];
        $i = 1;
        $restrictions = ['red' => 12, 'green' => 13, 'blue' => 14];
        foreach($lines as $key => &$line) { //color values tree
            if(strlen($line) == 0){
                unset($lines[$key]);
                continue;
            }
            $line = preg_replace('/Game \d+:/', '', $line);
            $setStrs = explode(';', $line);
            foreach($setStrs as $j => $setStr) {
                $colorStrs = explode(',', $setStr);
                foreach($colorStrs as $k => $cubeStr) {
                    $cube = explode(' ', trim($cubeStr));
                    $games[$i][$j][$cube[1]] = $cube[0];
                }
            }
            $i++;
        }

        function isGamePossible(array $game, array $restrictions) : bool{
            foreach ($game as $set) {
                foreach ($set as $color => $value) {
                    if ($value > $restrictions[$color]) {
                        return false;
                    }
                }
            }
            return true;
        }

        foreach($games as $i => $game) {
            if(isGamePossible($game, $restrictions)){
                $possibleIds[] = $i;
            }
        }

        return array_sum($possibleIds);
    }

    public static function puzzle_2023_2_2(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $games = [];
        $i = 1;
        $setPowerSum = 0;
        foreach($lines as $key => &$line) { //color values tree
            if(strlen($line) == 0){
                unset($lines[$key]);
                continue;
            }
            $line = preg_replace('/Game \d+:/', '', $line);
            $setStrs = explode(';', $line);
            foreach($setStrs as $j => $setStr) {
                $colorStrs = explode(',', $setStr);
                foreach($colorStrs as $k => $cubeStr) {
                    $cube = explode(' ', trim($cubeStr));
                    $games[$i][$j][$cube[1]] = $cube[0];
                }
            }
            $i++;
        }

        function minSetPower(array $game) : int {
            $max = ['red' => 0, 'green' => 0, 'blue' => 0];
            foreach ($game as $set) {
                foreach ($set as $color => $value) {
                    $max[$color] = max($max[$color], $value);
                }
            }
            return $max['red']*$max['green']*$max['blue'];
        }

        foreach($games as $game) {
            $setPowerSum += minSetPower($game);
        }

        return $setPowerSum;
    }

    public static function puzzle_2023_3_1(string $input) : int {
        $symbols = [];
        $nums = [];
        $sum = 0;
        $lines = explode(PHP_EOL, $input);
        foreach ($lines as $key => $line) {
            if(!preg_match_all('/([^\d|.])/', $line, $symbols[$key], PREG_OFFSET_CAPTURE))
                unset($symbols[$key]);
            if(!preg_match_all('/([\d]+)/', $line, $nums[$key], PREG_OFFSET_CAPTURE))
                unset($nums[$key]);
        }

        foreach ($nums as $key => $lineNums) {
            foreach ($lineNums[0] as $num) {
                for ($k = $key-1; $k <= $key+1; $k++) {
                    if (isset($symbols[$k])) {
                        foreach ($symbols[$k][0] as $symbol) {
                            if($symbol[1] >= $num[1]-1 && $symbol[1] <= $num[1] + strlen($num[0])){
                                $sum += intval($num[0]);
                                continue 3;
                            }
                        }
                    }
                }
            }
        }

        return $sum;
    }

    public static function puzzle_2023_3_2(string $input) : int {
        $gears = [];
        $nums = [];
        $sum = 0;
        $lines = explode(PHP_EOL, $input);
        foreach ($lines as $key => $line) {
            if(!preg_match_all('/\\*/', $line, $gears[$key], PREG_OFFSET_CAPTURE))
                unset($gears[$key]);
            if(!preg_match_all('/([\d]+)/', $line, $nums[$key], PREG_OFFSET_CAPTURE))
                unset($nums[$key]);
        }

        foreach ($gears as $key => $lineGears) {
            foreach ($lineGears[0] as $gear) {
                $gearNums = [];
                for ($k = $key-1; $k <= $key+1; $k++) {
                    if (isset($nums[$k])) {
                        foreach ($nums[$k][0] as $num) {
                            if($gear[1] >= $num[1]-1 && $gear[1] <= $num[1] + strlen($num[0])){
                                $gearNums[] = $num[0];
                            }
                        }
                    }
                }
                if(count($gearNums) == 2){
                    $sum += $gearNums[0] * $gearNums[1];
                }
            }
        }

        return $sum;
    }

    public static function puzzle_2023_4_1(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $totalScore = 0;
        foreach($lines as &$line) {
            $score = 0;
            $line = explode(' ', $line);
            $winning = [];
            $numbers = [];
            $isWinning = true;
            foreach ($line as $piece) {
                if ($piece == '|') {
                    $isWinning = false;
                    continue;
                }
                if (is_numeric($piece)) {
                    if ($isWinning) {
                        $winning[] = $piece;
                    } else {
                        $numbers[] = $piece;
                    }
                }
            }
            foreach ($numbers as $number) {
                if (in_array($number, $winning)) {
                    $score++;
                }
            }
            $score = $score > 0 ? 1 << $score-1 : 0;
            $totalScore += $score;
        }
        unset($line);
        return $totalScore;
    }

    public static function puzzle_2023_4_2(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $copies = [];
        foreach($lines as $key => $line) {
            $copies[$key] = 1;
        }
        foreach($lines as $key => &$line) {
            $score = 0;
            $line = explode(' ', $line);
            $winning = [];
            $numbers = [];
            $isWinning = true;
            foreach ($line as $piece) {
                if ($piece == '|') {
                    $isWinning = false;
                    continue;
                }
                if (is_numeric($piece)) {
                    if ($isWinning) {
                        $winning[] = $piece;
                    } else {
                        $numbers[] = $piece;
                    }
                }
            }
            foreach ($numbers as $number) {
                if (in_array($number, $winning)) {
                    $score++;
                }
            }
            for ($i = $key + 1; $i <= $key + $score; ++$i) {
                $copies[$i] += $copies[$key];
            }
        }
        unset($line);
        return array_sum($copies);
    }

    public static function puzzle_2023_5_1(string $input) : int {
        $sections = explode(PHP_EOL.PHP_EOL, trim($input));
        $maps = [];
        $seeds = [];
        foreach ($sections as $key => $section) {
            if ($key == 0) {
                $seedsLine = explode(" ", $section);
                $seeds = array_slice($seedsLine, 1, count($seedsLine));
                continue;
            }
            $sectionName = '';
            $sectionLines = explode(PHP_EOL, $section);
            foreach ($sectionLines as $lineKey => &$sectionLine) {
                $sectionLine = explode(' ', $sectionLine);
                if ($lineKey == 0) {
                    $sectionName = $sectionLine[0];
                    $maps[$sectionName] = [];
                    continue;
                }
                $maps[$sectionName][$lineKey] = ['destination' => $sectionLine[0], 'source' => $sectionLine[1], 'range' => $sectionLine[2]];
            }
            unset($sectionLine);
        }
        $locations = [];
        foreach ($seeds as $seed) {
            $currentThingToMap = $seed;
            foreach ($maps as $map) {
                foreach ($map as $mapEntry) {
                    if ($currentThingToMap >= $mapEntry['source'] && $currentThingToMap < $mapEntry['source'] + $mapEntry['range']) {
                        $currentThingToMap = $mapEntry['destination'] + $currentThingToMap - $mapEntry['source'];
                        continue 2;
                    }
                }
            }
            $locations[] = $currentThingToMap;
        }
        return min($locations);
    }

    public static function puzzle_2023_5_2(string $input) : int {       //To fix
        $sections = explode(PHP_EOL.PHP_EOL, trim($input));
        $maps = [];
        $seeds = [];
        foreach ($sections as $key => $section) {
            if ($key == 0) {
                $seedsLine = explode(" ", $section);
                $seedsLine = array_slice($seedsLine, 1, count($seedsLine));
                for ($i = 0; $i < count($seedsLine); ++$i) {
                    $seeds[intdiv($i, 2)][$i & 1 ? 'range' : 'start'] = $seedsLine[$i];
                }
                continue;
            }
            $sectionName = '';
            $sectionLines = explode(PHP_EOL, $section);
            foreach ($sectionLines as $lineKey => &$sectionLine) {
                $sectionLine = explode(' ', $sectionLine);
                if ($lineKey == 0) {
                    $sectionName = $sectionLine[0];
                    $maps[$sectionName] = [];
                    continue;
                }
                $maps[$sectionName][$lineKey] = [
                    'destination' => intval($sectionLine[0]),
                    'source' => intval($sectionLine[1]),
                    'range' => intval($sectionLine[2]),
                    'destinationEnd' => intval($sectionLine[0]) + intval($sectionLine[2]) - 1,
                    'sourceEnd' => intval($sectionLine[1]) + intval($sectionLine[2]) -1
                ];
            }
            unset($sectionLine);
        }
        $sourceBoundaries = []; //inclusive boundaries of map value ranges
        foreach ($maps as $mapKey => $map) {
            foreach ($map as $key => $entry) {
                $sourceBoundaries[$mapKey][] = $entry['source'];
                $sourceBoundaries[$mapKey][] = $entry['sourceEnd'];
            }
        }
        foreach ($maps as $mapKey => $map) {
            //first we determine if ranges need splitting
            //TODO complete this
        }
        dump($sourceBoundaries);
        dump($seeds);
        dump($maps);
        return 0;
    }

    public static function puzzle_2023_6_1(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $timesLine = preg_split('/\s+/', $lines[0]);
        $distancesLine = preg_split('/\s+/', $lines[1]);
        $times = array_slice($timesLine, 1, count($timesLine) - 1);
        $distances = array_slice($distancesLine, 1, count($distancesLine) - 1);
        $successes = [];
        for ($i = 0; $i < count($times); $i++) {    //interpreting the puzzle as quadratic function
            $times[$i] = intval($times[$i]);
            $distances[$i] = intval($distances[$i]);
            $delta = $times[$i]*$times[$i] - 4 * -1 * -1 * $distances[$i];
            $successes[$i] = (float)$times[$i] - 2 * ceil((-1 * $times[$i] + sqrt($delta))/-2) + 1;
            if (sqrt($delta) === floor(sqrt($delta))) { //greater than but not equal to 0
                $successes[$i] -= 2;
            }

        }
        return array_product($successes);
    }

    public static function puzzle_2023_6_2(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $timesLine = preg_split('/\s+/', $lines[0]);
        $distancesLine = preg_split('/\s+/', $lines[1]);
        $times = array_slice($timesLine, 1, count($timesLine) - 1);
        $distances = array_slice($distancesLine, 1, count($distancesLine) - 1);
        $time = intval(implode('', $times));
        $distance = intval(implode('', $distances));


        $delta = $time*$time - 4 * -1 * -1 * $distance;
        $successes = (float)$time - 2 * ceil((-1 * $time + sqrt($delta))/-2) + 1;
        if (sqrt($delta) === floor(sqrt($delta))) { //greater than but not equal to 0
            $successes-= 2;
        }

        return $successes;
    }
}
