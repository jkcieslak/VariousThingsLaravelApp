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

    public static function puzzle_2016_8_1(string $input) : int {
        $ROW_LENGTH = 50;
        $COL_LENGTH = 6;
        $screen = [];
        $lit = 0;
        for($i = 0; $i < $ROW_LENGTH; $i++) {
            for($j = 0; $j < $COL_LENGTH; $j++) {
                $screen[$i][$j] = 0;
            }
        }
        $lines = explode(PHP_EOL, trim($input));
        foreach($lines as $instruction) {
            $words = explode(' ', $instruction);
            if($words[0] == 'rect') {
                $nums = explode('x', $words[1]);
                $x = intval($nums[0]);
                $y = intval($nums[1]);
                for($i = 0; $i < $x; $i++) {
                    for($j = 0; $j < $y; $j ++) {
                        $screen[$i][$j] = 1;
                    }
                }
            }
            if($words[0] == 'rotate') {
                if($words[1] == 'row') {
                    $y = explode('=', $words[2])[1];
                    $val = intval($words[4]);
                    $initRow = [];
                    for($i = 0; $i < $ROW_LENGTH; $i++) {
                        $initRow[$i] = $screen[$i][$y];
                    }
                    for($i = 0; $i < $ROW_LENGTH; $i++) {
                        $screen[($i + $val) % $ROW_LENGTH][$y] = $initRow[$i];
                    }
                } else if ($words[1] == 'column') {
                    $x = explode('=', $words[2])[1];
                    $val = intval($words[4]);
                    $initCol = [];
                    for($j = 0; $j < $COL_LENGTH; $j++) {
                        $initCol[$j] = $screen[$x][$j];
                    }
                    for($j = 0; $j < $COL_LENGTH; $j++) {
                        $screen[$x][($j + $val) % $COL_LENGTH] = $initCol[$j];
                    }
                }
            }
        }
        foreach($screen as $column) {
            $lit+= array_sum($column);
        }
        return $lit;
    }

    public static function puzzle_2016_8_2(string $input) : string {
        $ROW_LENGTH = 50;
        $COL_LENGTH = 6;
        $screen = [];
        $lit = 0;
        for($i = 0; $i < $ROW_LENGTH; $i++) {
            for($j = 0; $j < $COL_LENGTH; $j++) {
                $screen[$i][$j] = 0;
            }
        }
        $lines = explode(PHP_EOL, trim($input));
        foreach($lines as $instruction) {
            $words = explode(' ', $instruction);
            if($words[0] == 'rect') {
                $nums = explode('x', $words[1]);
                $x = intval($nums[0]);
                $y = intval($nums[1]);
                for($i = 0; $i < $x; $i++) {
                    for($j = 0; $j < $y; $j ++) {
                        $screen[$i][$j] = 1;
                    }
                }
            }
            if($words[0] == 'rotate') {
                if($words[1] == 'row') {
                    $y = explode('=', $words[2])[1];
                    $val = intval($words[4]);
                    $initRow = [];
                    for($i = 0; $i < $ROW_LENGTH; $i++) {
                        $initRow[$i] = $screen[$i][$y];
                    }
                    for($i = 0; $i < $ROW_LENGTH; $i++) {
                        $screen[($i + $val) % $ROW_LENGTH][$y] = $initRow[$i];
                    }
                } else if ($words[1] == 'column') {
                    $x = explode('=', $words[2])[1];
                    $val = intval($words[4]);
                    $initCol = [];
                    for($j = 0; $j < $COL_LENGTH; $j++) {
                        $initCol[$j] = $screen[$x][$j];
                    }
                    for($j = 0; $j < $COL_LENGTH; $j++) {
                        $screen[$x][($j + $val) % $COL_LENGTH] = $initCol[$j];
                    }
                }
            }
        }
        $screenStr = '';
        for($j = 0; $j < $COL_LENGTH; $j++) {
            for($i = 0; $i < $ROW_LENGTH; $i++) {
                $screenStr.= $screen[$i][$j] ? '#' : ' ';
            }
            $screenStr.=PHP_EOL;
        }
        return $screenStr;
    }

    public static function puzzle_2016_9_1(string $input) : int {
        $input = trim($input);
        $decompressed = [];
        $i = 0;
        while (isset($input[$i])) {
            if($input[$i] != '('){
                $decompressed[] = $input[$i];
                $i++;
            }
            if($input[$i] == '('){
                $seqLength = 0;
                $seqTimes = 0;
                //read next two numbers
                while($input[$i] != 'x') {
                    $seqLength = $seqLength * 10 + intval($input[$i]);
                    $i++;
                }
                $i++;
                while($input[$i] != ')') {
                    $seqTimes = $seqTimes * 10 + intval($input[$i]);
                    $i++;
                }
                $i++;
                $sequence = substr($input, $i, $seqLength);
                for($j = 0; $j < $seqTimes; $j++) {
                    $decompressed[] = $sequence;
                }
                $i += $seqLength;
            }
        }
        $decompressed = implode($decompressed);
        return strlen($decompressed);
    }

    public static function puzzle_2016_9_2(string $input) : int {
        $input = trim($input);
        $length = 0;
        $weights = [];
        for($i = 0; $i < strlen($input); $i ++) {
            $weights[$i] = 1;
        }
        $i = 0;
        while (isset($input[$i])) {
            if ($input[$i] != '('){
                $length += $weights[$i];
                $i++;
            } else {
                $seqLength = 0;
                $seqTimes = 0;
                //read next two numbers
                while ($input[$i] != 'x') {
                    $seqLength = $seqLength * 10 + intval($input[$i]);
                    $i++;
                }
                $i++;
                while ($input[$i] != ')') {
                    $seqTimes = $seqTimes * 10 + intval($input[$i]);
                    $i++;
                }
                $i++;
                for ($j = 0; $j < $seqLength; $j++) {
                    $weights[$i + $j] *= $seqTimes;
                }
            }
        }
        return $length;
    }

    public static function puzzle_2016_10_1(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $objects = [];
        $waiting = [];
        foreach($lines as $line) {  //creating a graph
            $words = explode(' ', $line);
            if($words[0] == 'bot') {
                $botId = 'b'.$words[1];
                $lowPrefix = str_starts_with($words[5], 'b') ? 'b' : 'o';
                $lowId = $lowPrefix.$words[6];
                $highPrefix = str_starts_with($words[10], 'b') ? 'b' : 'o';
                $highId = $highPrefix.$words[11];
                if(!isset($objects[$botId]))
                    $objects[$botId] = ['values' => []];
                $objects[$botId]['lowId'] = $lowId;
                $objects[$botId]['highId'] = $highId;
                if(isset($waiting[$botId])){
                    $waiting[$botId]['lowId'] = $lowId;
                    $waiting[$botId]['highId'] = $highId;
                }
            }
            if($words[0] == 'value') {
                $botId = 'b'.$words[5];
                $value = intval($words[1]);
                if(!isset($objects[$botId]))
                    $objects[$botId] = ['values' => []];
                $objects[$botId]['values'][] = $value;
                $waiting[$botId] = $objects[$botId];
            }
        }

        $curr = [];
        foreach($waiting as $key => $w) {
            if(count($w['values']) == 2) {
                $curr[$key] = $w;
            }
        }
        while(count($curr) > 0) {
            $key = array_key_first($curr);
            $lowId = $curr[$key]['lowId'];
            $highId = $curr[$key]['highId'];
            $lowerVal = min($curr[$key]['values']);
            $higherVal = max($curr[$key]['values']);

            if ($lowerVal == 17 && $higherVal == 61) {
                return intval(substr($key, 1));
            }

            $objects[$lowId]['values'][] = $lowerVal;
            if (str_starts_with($lowId, 'b') && array_key_exists($lowId, $waiting)) {
                $curr[$lowId] = $objects[$lowId];
                unset($waiting[$lowId]);
            } else {
                $waiting[$lowId] = $objects[$lowId];
            }
            $objects[$highId]['values'][] = $higherVal;
            if (str_starts_with($highId, 'b') && array_key_exists($highId, $waiting)) {
                $curr[$highId] = $objects[$highId];
                unset($waiting[$highId]);
            } else {
                $waiting[$highId] = $objects[$highId];
            }
            unset($curr[$key]);
        }
        return 0;
    }

    public static function puzzle_2016_10_2(string $input) : int {
        $lines = explode(PHP_EOL, trim($input));
        $objects = [];
        $waiting = [];
        foreach($lines as $line) {  //creating a graph
            $words = explode(' ', $line);
            if($words[0] == 'bot') {
                $botId = 'b'.$words[1];
                $lowPrefix = str_starts_with($words[5], 'b') ? 'b' : 'o';
                $lowId = $lowPrefix.$words[6];
                $highPrefix = str_starts_with($words[10], 'b') ? 'b' : 'o';
                $highId = $highPrefix.$words[11];
                if(!isset($objects[$botId]))
                    $objects[$botId] = ['values' => []];
                $objects[$botId]['lowId'] = $lowId;
                $objects[$botId]['highId'] = $highId;
                if(isset($waiting[$botId])){
                    $waiting[$botId]['lowId'] = $lowId;
                    $waiting[$botId]['highId'] = $highId;
                }
            }
            if($words[0] == 'value') {
                $botId = 'b'.$words[5];
                $value = intval($words[1]);
                if(!isset($objects[$botId]))
                    $objects[$botId] = ['values' => []];
                $objects[$botId]['values'][] = $value;
                $waiting[$botId] = $objects[$botId];
            }
        }

        $curr = [];
        foreach($waiting as $key => $w) {
            if(count($w['values']) == 2) {
                $curr[$key] = $w;
            }
        }
        while(count($curr) > 0) {
            $key = array_key_first($curr);
            $lowId = $curr[$key]['lowId'];
            $highId = $curr[$key]['highId'];
            $lowerVal = min($curr[$key]['values']);
            $higherVal = max($curr[$key]['values']);

            $objects[$lowId]['values'][] = $lowerVal;
            if (str_starts_with($lowId, 'b') && array_key_exists($lowId, $waiting)) {
                $curr[$lowId] = $objects[$lowId];
                unset($waiting[$lowId]);
            } else {
                $waiting[$lowId] = $objects[$lowId];
            }
            $objects[$highId]['values'][] = $higherVal;
            if (str_starts_with($highId, 'b') && array_key_exists($highId, $waiting)) {
                $curr[$highId] = $objects[$highId];
                unset($waiting[$highId]);
            } else {
                $waiting[$highId] = $objects[$highId];
            }
            unset($curr[$key]);
        }
        return $objects['o0']['values'][0] * $objects['o1']['values'][0] * $objects['o2']['values'][0];
    }
}
