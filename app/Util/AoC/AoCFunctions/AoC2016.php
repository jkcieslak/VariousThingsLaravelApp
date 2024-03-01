<?php

namespace App\Util\AoC\AoCFunctions;

use App\Util\AoC\AoCException;
use ErrorException;

class AoC2016
{
    /**
     * @throws AoCException
     */
    public static function puzzle_2016_1_1(string $input) : int {
        $direction = 'N';
        $rotLeft = ['N' => 'W', 'W' => 'S', 'S' => 'E', 'E' => 'N'];
        $rotRight = ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'];
        $position = ['x' => 0, 'y' => 0];
        $instructions = explode(', ', trim($input));
        foreach($instructions as $instruction) {
            //Decode instruction
            $rotation = substr($instruction, 0, 1);
            //Turn
            switch($rotation) {
                case 'L':
                    $direction = $rotLeft[$direction];
                    break;
                case 'R':
                    $direction = $rotRight[$direction];
                    break;
                default:
                    throw new AoCException("Invalid input data rotation.");
            }
            //Move
            $distance = (int)filter_var($instruction, FILTER_SANITIZE_NUMBER_INT);
            switch($direction) {
                case 'N':
                    $position['y'] += $distance;
                    break;
                case 'S':
                    $position['y'] -= $distance;
                    break;
                case 'E':
                    $position['x'] += $distance;
                    break;
                case 'W':
                    $position['x'] -= $distance;
                    break;
                default:
                    throw new AoCException("Invalid input data distance");
            }
        }

        return abs($position['x']) + abs($position['y']);
    }

    public static function puzzle_2016_1_2(string $input) : int {
        $direction = 'N';
        $rotLeft = ['N' => 'W', 'W' => 'S', 'S' => 'E', 'E' => 'N'];
        $rotRight = ['N' => 'E', 'E' => 'S', 'S' => 'W', 'W' => 'N'];
        $position = ['x' => 0, 'y' => 0];
        $visited = [$position];
        $instructions = explode(', ', trim($input));
        foreach($instructions as $instruction) {
            //Decode instruction
            $rotation = substr($instruction, 0, 1);
            //Turn
            switch ($rotation) {
                case 'L':
                    $direction = $rotLeft[$direction];
                    break;
                case 'R':
                    $direction = $rotRight[$direction];
                    break;
                default:
                    throw new AoCException("Invalid input data rotation.");
            }
            //Move step by step
            $distance = (int)filter_var($instruction, FILTER_SANITIZE_NUMBER_INT);
            for ($i = 0; $i < $distance; $i++) {
                switch ($direction) {
                    case 'N':
                        $position['y'] += 1;
                        break;
                    case 'S':
                        $position['y'] -= 1;
                        break;
                    case 'E':
                        $position['x'] += 1;
                        break;
                    case 'W':
                        $position['x'] -= 1;
                        break;
                    default:
                        throw new AoCException("Invalid input data distance");
                }
                //Check if already visited
                if(in_array($position, $visited)){
                    dump($visited);
                    return abs($position['x']) + abs($position['y']);
                }
                $visited[] = $position;
            }
        }

        throw new AoCException("No solution found.");
    }

    /**
     * @throws AoCException
     */
    public static function puzzle_2016_2_1(string $input) : int {
        $code = 0;
        $button = 5;
        $digitInstructions = explode(PHP_EOL, trim($input));
        foreach ($digitInstructions as $digitInstruction) {
            $buttonInstructions = str_split($digitInstruction, 1);
            foreach ($buttonInstructions as $buttonInstruction) {
                $button = match ($buttonInstruction) {
                    'U' => ($button >= 4) ? $button - 3 : $button,
                    'D' => ($button <= 6) ? $button + 3 : $button,
                    'L' => ($button % 3 != 1) ? $button - 1 : $button,
                    'R' => ($button % 3 != 0) ? $button + 1 : $button,
                    default => throw new AoCException("Invalid code instruction"),
                };
            }
            $code = $code * 10 + $button;
        }
        return $code;
    }

    /**
     * @throws AoCException
     */
    public static function puzzle_2016_2_2(string $input) : string {
        $code = [];
        $codePad = [
            [0, 0, 1, 0, 0],
            [0, 2, 3, 4, 0],
            [5, 6, 7, 8, 9],
            [0, 'A', 'B', 'C', 0],
            [0, 0, 'D', 0, 0]
        ];
        $y = 2;
        $x = 0;
        $digitInstructions = explode(PHP_EOL, trim($input));
        foreach ($digitInstructions as $digitInstruction) {
            $buttonInstructions = str_split($digitInstruction, 1);
            foreach ($buttonInstructions as $buttonInstruction) {
                switch ($buttonInstruction) {
                    case 'U':
                        if(isset($codePad[$y-1][$x]) && $codePad[$y-1][$x] != 0)
                            $y--;
                        break;
                    case 'D':
                        if(isset($codePad[$y+1][$x]) && $codePad[$y+1][$x] != 0)
                            $y++;
                        break;
                    case 'L':
                        if(isset($codePad[$y][$x-1]) && $codePad[$y][$x-1] != 0)
                            $x--;
                        break;
                    case 'R':
                        if(isset($codePad[$y][$x+1]) && $codePad[$y][$x+1] != 0)
                            $x++;
                        break;
                    default:
                        throw new AoCException("Invalid code instruction");
                }
            }
            $code[] = $codePad[$y][$x];
        }
        return implode('', $code);
    }

    public static function puzzle_2016_3_1(string $input) : int {
        $possible = 0;
        $triangles = explode(PHP_EOL, trim($input));
        foreach($triangles as $triangle) {
            $sides = [];
            preg_match_all('/\d+/', $triangle, $sides);
            $a = intval($sides[0][0]);
            $b = intval($sides[0][1]);
            $c = intval($sides[0][2]);
            if($a >= $b + $c || $b >= $a + $c || $c >= $a + $b) {
                continue;
            }
            $possible++;
        }
        return $possible;
    }

    public static function puzzle_2016_3_2(string $input) : int {
        $possible = 0;
        $triangles = explode(PHP_EOL, trim($input));
        foreach($triangles as &$triangle) {
            $sides = [];
            preg_match_all('/\d+/', $triangle, $sides);
            $triangle = $sides[0];
        }
        unset($triangle);
        for($i = 0; $i < count($triangles); $i += 3) {
            for($j = 0; $j < 3; $j++) {
                $a = intval($triangles[$i][$j]);
                $b = intval($triangles[$i+1][$j]);
                $c = intval($triangles[$i+2][$j]);
                if($a >= $b + $c || $b >= $a + $c || $c >= $a + $b) {
                    continue;
                }
                $possible++;
            }
        }
        return $possible;
    }

    public static function puzzle_2016_4_1(string $input) : int {
        $rooms = explode(PHP_EOL, trim($input));
        $sectorSum = 0;

        foreach($rooms as $room){
            $segs = explode('-', $room);

            $control = array_pop($segs);
            $control = str_replace(']', '', $control);
            $control = explode('[', $control);
            $sectorId = intval($control[0]);
            $checkSum = $control[1];
            $checkSum = str_split($checkSum, 1);

            $counts = count_chars(implode('', $segs), 1);
            arsort($counts);
            $topChars = [];
            foreach($counts as $key => $count) {
                $topChars[] = chr($key);
            }

            for ($i = 0; $i < count($checkSum); $i++) {
                if($topChars[$i] != $checkSum[$i]) {
                    continue 2;
                }
            }
            $sectorSum += $sectorId;
        }

        return $sectorSum;
    }

    public static function puzzle_2016_4_2(string $input) : int {
        $rooms = explode(PHP_EOL, trim($input));
        $realRooms = [];

        foreach($rooms as $room){
            $segs = explode('-', $room);

            $control = array_pop($segs);
            $control = str_replace(']', '', $control);
            $control = explode('[', $control);
            $sectorId = intval($control[0]);
            $checkSum = $control[1];
            $checkSum = str_split($checkSum, 1);

            $counts = count_chars(implode('', $segs), 1);
            arsort($counts);
            $topChars = [];
            foreach($counts as $key => $count) {
                $topChars[] = chr($key);
            }

            for ($i = 0; $i < count($checkSum); $i++) {
                if($topChars[$i] != $checkSum[$i]) {
                    continue 2;
                }
            }
            $realRooms[] = ['encryptedName' => implode('-', $segs), 'sectorId' => $sectorId];
        }

        foreach ($realRooms as &$room) {
            $encryptedChars = str_split($room['encryptedName']);
            $chars = [];
            foreach($encryptedChars as $enChar) {
                if($enChar == '-') {
                    $chars[] = ' ';
                    continue;
                }
                $chars[] = chr(ord('a') + ((ord($enChar)-ord('a') + $room['sectorId']) % 26));
            }
            $room['name'] = implode('', $chars);
            $match = [];
            if(preg_match('/north/', $room['name'], $match) > 0) {
                return $room['sectorId'];
            }
        }
        unset($room);

        dump($realRooms);

        return 0;
    }

    public static function puzzle_2016_5_1(string $input) : string {
        $passcode = [];
        $i = 0;
        while(count($passcode) < 8) {
            $hash = md5(trim($input).$i);
            if(str_starts_with($hash, '00000')){
                dump($hash);
                $passcode[] = substr($hash, 5, 1);
            }
            $i++;
        }
        return implode('', $passcode);
    }

    public static function puzzle_2016_5_2(string $input) : string {
        $passcode = [];
        $i = 0;
        while(count($passcode) < 8) {
            $hash = md5(trim($input).$i);
            if(str_starts_with($hash, '00000')) {
                if(isset($passcode[$hash[5]]) || !is_numeric($hash[5]) || $hash[5] > 7 ) {
                    $i++;
                    continue;
                }
                dump($hash);
                $passcode[intval($hash[5])] = $hash[6];
            }
            $i++;
        }
        ksort($passcode);
        return implode('', $passcode);
    }

    public static function puzzle_2016_6_1(string $input) : string {
        $message = '';
        $lines = explode(PHP_EOL, $input);
        $columns = [];
        foreach ($lines as $line) {
            for($i = 0; $i < strlen($line); $i++) {
                $columns[$i][] = $line[$i];
            }
        }
        $columnFreqs = [];
        foreach($columns as $key => $column) {
            $columnFreqs[$key] = array_count_values($column);
            arsort($columnFreqs[$key]);
            $message .= array_key_first($columnFreqs[$key]);
        }
        return $message;
    }

    public static function puzzle_2016_6_2(string $input) : string {
        $message = '';
        $lines = explode(PHP_EOL, $input);
        $columns = [];
        foreach ($lines as $line) {
            for($i = 0; $i < strlen($line); $i++) {
                $columns[$i][] = $line[$i];
            }
        }
        $columnFreqs = [];
        foreach($columns as $key => $column) {
            $columnFreqs[$key] = array_count_values($column);
            asort($columnFreqs[$key]);
            $message .= array_key_first($columnFreqs[$key]);
        }
        return $message;
    }

    public static function puzzle_2016_7_1(string $input) : string {
        $ips = 0;
        $lines = explode(PHP_EOL, trim($input));
        foreach($lines as $line) {
            $line = str_replace('[', ']', $line);
            $line = explode(']', $line);

            //search for abba in bracket
            for($j = 1; $j < count($line); $j +=2 ){
                for($i = 0; $i < strlen($line[$j]) - 3; $i++) {
                    if($line[$j][$i] != $line[$j][$i + 1] && $line[$j][$i] == $line[$j][$i + 3] && $line[$j][$i + 1] == $line[$j][$i + 2]) {
                        continue 3;
                    }
                }
            }
            //search for abba outside brackets
            for($j = 0; $j < count($line); $j += 2) {
                for($i = 0; $i < strlen($line[$j]) - 3; $i++) {
                    if($line[$j][$i] != $line[$j][$i + 1] && $line[$j][$i] == $line[$j][$i + 3] && $line[$j][$i + 1] == $line[$j][$i + 2]) {
                        $ips++;
                        continue 3;
                    }
                }
            }
        }
        return $ips;
    }

    public static function puzzle_2016_7_2(string $input) : string {
        $ips = 0;
        $lines = explode(PHP_EOL, trim($input));
        foreach($lines as $line) {
            $line = str_replace('[', ']', $line);
            $line = explode(']', $line);
            $babCandidates = [];
            //search for BAB candidates outside brackets
            for($j = 0; $j < count($line); $j += 2) {
                for($i = 0; $i < strlen($line[$j]) - 2; $i++) {
                    if($line[$j][$i] != $line[$j][$i + 1] && $line[$j][$i] == $line[$j][$i + 2]){
                        $babCandidates[] = ($line[$j][$i + 1]).($line[$j][$i]).($line[$j][$i + 1]);
                    }
                }
            }
            //check if any of corresponding BABs can be found inside brackets
            for($j = 1; $j < count($line); $j += 2) {
                foreach($babCandidates as $babCandidate) {
                    if(str_contains($line[$j], $babCandidate)) {
                        $ips++;
                        continue 3;
                    }
                }
            }
        }
        return $ips;
    }

}
