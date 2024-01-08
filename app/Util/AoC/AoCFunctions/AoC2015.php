<?php

namespace App\Util\AoC\AoCFunctions;

use App\Util\AoC\AoCException;

class AoC2015
{
    public static function puzzle_2015_1_1(string $input) : int {
        return substr_count($input, '(') - substr_count($input, ')');
    }

    /**
     * @throws AoCException
     */
    public static function puzzle_2015_1_2(string $input) : int {
        $floor = 0;
        $movement = ['(' => 1, ')' => -1];
        $i = 0;
        foreach(mb_str_split($input) as $character){
            $i++;
            $floor += $movement[$character];
            if($floor < 0) {
                return $i;
            }
        }
        throw new AoCException("Puzzle has no answer for given input.");
    }
    public static function puzzle_2015_2_1(string $input) : int {
        $totalArea = 0;
        $lines = explode(PHP_EOL, $input);
        foreach ($lines as $line) {
            $values = array_map('intval', explode('x', $line));
            if(sizeof($values) != 3) {
                return $totalArea;
            }
            sort($values);
            $totalArea += ( 3 * $values[0] * $values[1] + 2 * $values[0] * $values[2] + 2 * $values[1] * $values[2]);
        }
        return $totalArea;
    }

    public static function puzzle_2015_2_2(string $input) : int {
        $totalLength = 0;
        $lines = explode(PHP_EOL, $input);
        foreach ($lines as $line) {
            $values = array_map('intval', explode('x', $line));
            if(sizeof($values) != 3) {
                return $totalLength;
            }
            sort($values);
            $totalLength += ( 2 * $values[0] + 2 * $values[1] + $values[0] * $values[1] * $values[2]);
        }
        return $totalLength;
    }

    public static function puzzle_2015_3_1(string $input) : int {
        $x = 0;
        $y = 0;
        $presents[0][0] = 1;
        foreach(mb_str_split($input) as $character){
            switch($character) {
                case '^':
                    $y++;
                    break;
                case 'v':
                    $y--;
                    break;
                case '>':
                    $x++;
                    break;
                case '<':
                    $x--;
                    break;
                default:
                    break;
            }
            $presents[$x][$y] = isset($presents[$x][$y]) ? $presents[$x][$y] + 1 : 1;
        }
        return count($presents, COUNT_RECURSIVE) - count($presents);
    }

    public static function puzzle_2015_3_2(string $input) : int {
        $x[0] = 0;  //Santa
        $y[0] = 0;
        $x[1] = 0;  //Robot
        $y[1] = 0;
        $presents[0][0] = 2;
        $isRobotsTurn = false;
        foreach(mb_str_split($input) as $char){
            $isRobot = (int)$isRobotsTurn;
            $isRobotsTurn = !$isRobotsTurn;
            switch($char) {
                case '^':
                    $y[$isRobot]++;
                    break;
                case 'v':
                    $y[$isRobot]--;
                    break;
                case '>':
                    $x[$isRobot]++;
                    break;
                case '<':
                    $x[$isRobot]--;
                    break;
                default:
                    break;
            }
            $presents[$x[$isRobot]][$y[$isRobot]] = isset($presents[$x[$isRobot]][$y[$isRobot]]) ? $presents[$x[$isRobot]][$y[$isRobot]] + 1 : 1;
        }
        return count($presents, COUNT_RECURSIVE) - count($presents);
    }

    public static function puzzle_2015_4_1(string $input) : int {
        $puzzleKey = trim($input);
        for($i = 0; ; $i++) {
            $hashStr = hash('md5', $puzzleKey.$i);
            if(str_starts_with($hashStr, '00000')){
                return $i;
            }
        }
    }

    public static function puzzle_2015_4_2(string $input) : int {
        $puzzleKey = trim($input);
        for($i = 0; ; $i++) {
            $hashStr = hash('md5', $puzzleKey.$i);
            if(str_starts_with($hashStr, '000000')){
                return $i;
            }
        }
    }

    public static function puzzle_2015_5_1(string $input) : int {
        $strings = explode(PHP_EOL, $input);
        $nice = [];
        $naughty = [];
        foreach($strings as $string) { //Check the requirements for a nice string
            //Contains at least three Vowels
            if(preg_match_all('/[aeiou]/i', $string) < 3) {
                $naughty[] = $string;
                continue;
            }
            //Contains at least one letter that appears twice in a row
            if(!preg_match('/(.)\1/', $string)) {
                $naughty[] = $string;
                continue;
            }
            //Does not contain strings ab, cd, pq, xy
            if(array_reduce(['ab', 'cd', 'pq', 'xy'], fn($a, $n) => $a || str_contains($string, $n ), false)) {
                $naughty[] = $string;
                continue;
            }
            $nice[] = $string;
        }
        return count($nice);
    }

    public static function puzzle_2015_5_2(string $input) : int {
        $strings = explode(PHP_EOL, $input);
        $nice = [];
        $naughty = [];
        foreach($strings as $string) { //Check the requirements for a nice string
            //Contains at least two pairs of letters that don't overlap
            if(!preg_match('/(..).*\1/', $string)){
                $naughty[] = $string;
                continue;
            }
            //Contains at least one letter that repeats with exactly one letter between them
            if(!preg_match('/(.).\1/', $string)) {
                $naughty[] = $string;
                continue;
            }
            $nice[] = $string;
        }
        return count($nice);
    }

    /**
     * @throws AoCException
     */
    public static function puzzle_2015_6_1(string $input) : int {
        $lights = [];
        $lines = explode(PHP_EOL, $input);
        foreach($lines as $line) {
            $match = [];
            if(!preg_match('/(turn off|turn on|toggle)/', $line, $match)) {
                break;
            }
            $command = $match[0];
            preg_match_all('/\d+/', $line, $match);
            $coordinates = $match[0];
            for($x = $coordinates[0]; $x <= $coordinates[2]; $x++) {
                for($y = $coordinates[1]; $y <= $coordinates[3]; $y++) {
                    $lights[$x][$y] = match ($command) {
                        'turn off' => 0,
                        'turn on' => 1,
                        'toggle' => (isset($lights[$x][$y]) && $lights[$x][$y] == 1) ? 0 : 1,
                        default => throw new AoCException("Invalid input data"),
                    };
                }
            }
        }
        $lit = 0;
        foreach($lights as $lightRow){
            $lit += array_sum($lightRow);
        }
        return $lit;
    }

    /**
     * @throws AoCException
     */
    public static function puzzle_2015_6_2(string $input) : int {
        $lights = [];
        for($i = 0; $i < 1000; $i++){
            for($j = 0; $j < 1000; $j++){
                $lights[$i][$j] = 0;
            }
        }
        $lines = explode(PHP_EOL, $input);
        foreach($lines as $line) {
            $match = [];
            if(!preg_match('/(turn off|turn on|toggle)/', $line, $match)) {
                break;
            }
            $command = $match[0];
            preg_match_all('/\d+/', $line, $match);
            $coordinates = $match[0];
            for($x = $coordinates[0]; $x <= $coordinates[2]; $x++) {
                for($y = $coordinates[1]; $y <= $coordinates[3]; $y++) {
                    $lights[$x][$y] = match ($command) {
                        'turn off' => max($lights[$x][$y]-1, 0),
                        'turn on' => $lights[$x][$y]+1,
                        'toggle' => $lights[$x][$y]+2,
                        default => throw new AoCException("Invalid input data"),
                    };
                }
            }
        }
        $lit = 0;
        foreach($lights as $lightRow){
            $lit += array_sum($lightRow);
        }
        return $lit;
    }

    public static function puzzle_2015_7_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $wires = [];
        foreach ($lines as $line) { //input parsing
            if (strlen($line) == 0) {
                continue;
            }
            $operands = [];
            $result = '';
            $operator = '';
            $parts = explode(' ', $line);
            foreach ($parts as $i => $part) {
                if ($i == count($parts) - 1) {
                    $result = $part;
                    continue;
                }
                if (ctype_lower($part)) {
                    $operands[] = $part;
                }
                if (ctype_upper($part)) {
                    $operator = $part;
                }
                if ($part == '->') {
                    continue;
                }
                if (is_numeric($part)) {
                    $operands[] = (int)$part;
                }
            }
            $wires[$result] = [];
            $wires[$result]['operator'] = $operator;
            $wires[$result]['operands'] = $operands;
            $wires[$result]['name'] = $result;
        }

        //getting value with recursion and memoization
        $values = [];
        function getVal($wireName, &$values, $wires) {
            if (isset($values[$wireName])) {    //get memoized value
                return $values[$wireName];
            }
            if (is_int($wireName)) {    //get primitive value
                return $wireName;
            }
            $wire = $wires[$wireName];
            $values[$wireName] = match ($wires[$wireName]['operator']) {    //operate
                'NOT' => ~getVal($wire['operands'][0], $values, $wires),
                'AND' => getVal($wire['operands'][0], $values, $wires) & getVal($wire['operands'][1], $values, $wires),
                'OR' => getVal($wire['operands'][0], $values, $wires) | getVal($wire['operands'][1], $values, $wires),
                'LSHIFT' => getVal($wire['operands'][0], $values, $wires) << getVal($wire['operands'][1], $values, $wires),
                'RSHIFT' => getVal($wire['operands'][0], $values, $wires) >> getVal($wire['operands'][1], $values, $wires),
                '' => getVal($wire['operands'][0], $values, $wires),
            };
            return $values[$wireName];
        }

        return getVal('a',$values, $wires);
    }

    public static function puzzle_2015_7_2(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $wires = [];
        foreach ($lines as $line) { //input parsing
            if (strlen($line) == 0) {
                continue;
            }
            $operands = [];
            $result = '';
            $operator = '';
            $parts = explode(' ', $line);
            foreach ($parts as $i => $part) {
                if ($i == count($parts) - 1) {
                    $result = $part;
                    continue;
                }
                if (ctype_lower($part)) {
                    $operands[] = $part;
                }
                if (ctype_upper($part)) {
                    $operator = $part;
                }
                if ($part == '->') {
                    continue;
                }
                if (is_numeric($part)) {
                    $operands[] = (int)$part;
                }
            }
            $wires[$result] = [];
            $wires[$result]['operator'] = $operator;
            $wires[$result]['operands'] = $operands;
            $wires[$result]['name'] = $result;
        }

        //getting value with recursion and memoization
        $values = [];
        function getVal($wireName, &$values, $wires) {
            if (isset($values[$wireName])) {    //get memoized value
                return $values[$wireName];
            }
            if (is_int($wireName)) {    //get primitive value
                return $wireName;
            }
            $wire = $wires[$wireName];
            $values[$wireName] = match ($wires[$wireName]['operator']) {    //operate
                'NOT' => ~getVal($wire['operands'][0], $values, $wires),
                'AND' => getVal($wire['operands'][0], $values, $wires) & getVal($wire['operands'][1], $values, $wires),
                'OR' => getVal($wire['operands'][0], $values, $wires) | getVal($wire['operands'][1], $values, $wires),
                'LSHIFT' => getVal($wire['operands'][0], $values, $wires) << getVal($wire['operands'][1], $values, $wires),
                'RSHIFT' => getVal($wire['operands'][0], $values, $wires) >> getVal($wire['operands'][1], $values, $wires),
                '' => getVal($wire['operands'][0], $values, $wires),
            };
            return $values[$wireName];
        }

        $a = getVal('a', $values, $wires);
        $values = [];
        $values['b'] = $a;

        return getVal('a', $values, $wires);
    }

    public static function puzzle_2015_8_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $totalDiff = 0;

        foreach ($lines as $line) { //char by char
            $lineLength = strlen($line);
            $finalLineLength = 0;
            if ($lineLength == 0)
                continue;
            $splitLine = str_split($line);
            for ($i = 0; $i < $lineLength; $i++) {
                if ($splitLine[$i] == '"') {
                    continue;
                }
                $finalLineLength++;
                if ($splitLine[$i] == '\\') {
                    $i += $splitLine[$i+1] == 'x' ? 3 : 1;   //continue counting after escaped character
                }
            }
            $totalDiff += $lineLength - $finalLineLength;
        }
        return $totalDiff;
    }

    public static function puzzle_2015_8_2(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $totalDiff = 0;

        foreach ($lines as $line) { //char by char
            $lineLength = strlen($line);
            if ($lineLength == 0)
                continue;
            $finalLineLength = 2;
            $splitLine = str_split($line);
            for ($i = 0; $i < $lineLength; $i++) {
                if ($splitLine[$i] == '"' || $splitLine[$i] == "\\") {
                    $finalLineLength++;
                }
                $finalLineLength++;
            }
            $totalDiff += $finalLineLength - $lineLength;
        }
        return $totalDiff;
    }

    public static function puzzle_2015_9_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $adjacencyMatrix = [];
        foreach ($lines as $line) {
            if( strlen($line) == 0) {
                continue;
            }
            $lineArgs = explode(' ', $line);
            $adjacencyMatrix[$lineArgs[0]][$lineArgs[0]] = 0;
            $adjacencyMatrix[$lineArgs[2]][$lineArgs[2]] = 0;
            $adjacencyMatrix[$lineArgs[0]][$lineArgs[2]] = $lineArgs[4];
            $adjacencyMatrix[$lineArgs[2]][$lineArgs[0]] = $lineArgs[4];
        }
        $locations = array_keys($adjacencyMatrix);

        function findShortestRoute($current, $locations, $visited, $adjMatrix) {
            $visited[] = $current;
            $left = array_diff($locations, $visited);
            if(count($left) == 1){
                return $adjMatrix[$current][$left[(key($left))]];
            }
            $routesVals = array_map(fn($arg) => $adjMatrix[$current][$arg] + findShortestRoute($arg, $locations, $visited, $adjMatrix), $left);
            return min($routesVals);
        }
        $routes = array_map(fn($a) => findShortestRoute($a, $locations, [], $adjacencyMatrix), $locations);
        return min($routes);
    }

    public static function puzzle_2015_9_2(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $adjacencyMatrix = [];
        foreach ($lines as $line) {
            if( strlen($line) == 0) {
                continue;
            }
            $lineArgs = explode(' ', $line);
            $adjacencyMatrix[$lineArgs[0]][$lineArgs[0]] = 0;
            $adjacencyMatrix[$lineArgs[2]][$lineArgs[2]] = 0;
            $adjacencyMatrix[$lineArgs[0]][$lineArgs[2]] = $lineArgs[4];
            $adjacencyMatrix[$lineArgs[2]][$lineArgs[0]] = $lineArgs[4];
        }
        $locations = array_keys($adjacencyMatrix);

        function findLongestRoute($current, $locations, $visited, $adjMatrix) {
            $visited[] = $current;
            $left = array_diff($locations, $visited);
            if(count($left) == 1){
                return $adjMatrix[$current][$left[(key($left))]];
            }
            $routesVals = array_map(fn($arg) => $adjMatrix[$current][$arg] + findLongestRoute($arg, $locations, $visited, $adjMatrix), $left);
            return max($routesVals);
        }
        $routes = array_map(fn($a) => findLongestRoute($a, $locations, [], $adjacencyMatrix), $locations);
        return max($routes);
    }

    public static function puzzle_2015_10_1(string $input) : int {
        $output = $input;
        function lookAndSay($string) {
            $groups = [];
            preg_match_all('/1+|2+|3+/', $string, $groups);
            $newString = [];
            foreach ($groups[0] as $group) {
                if (strlen($group) == 0) {
                    continue;
                }
                $newString[] = strlen($group);
                $newString[] = $group[0];
            }
            return implode('', $newString);
        }

        for ($i = 0; $i < 40; ++$i) {
            $output = lookAndSay($output);
        }

        return strlen($output);
    }

    public static function puzzle_2015_10_2(string $input) : int {
        $output = $input;
        function lookAndSay($string) {
            $groups = [];
            preg_match_all('/1+|2+|3+/', $string, $groups);
            $newString = [];
            foreach ($groups[0] as $group) {
                if (strlen($group) == 0) {
                    continue;
                }
                $newString[] = strlen($group);
                $newString[] = $group[0];
            }
            return implode('', $newString);
        }

        for ($i = 0; $i < 50; ++$i) {
            $output = lookAndSay($output);
        }

        return strlen($output);
    }

    public static function puzzle_2015_11_1(string $input) : string {
        $input = trim($input);
        function checkStraight(string $password) : bool {
            for ($i = 0; $i < strlen($password) - 2; $i++) {
                $char = $password[$i];
                if ($char == 'z' || $char == 'y'){
                    continue;
                }
                if ($password[$i+1] == ++$char && $password[$i+2] == ++$char) {
                    return true;
                }
            }
            return false;
        }

        function checkForbidden(string $password) : bool {
            return !(str_contains($password, 'i') || str_contains($password,'l') || str_contains($password,'o'));
        }

        function checkPairs(string $password) : bool {
            $matches = [];
            preg_match_all('/([a-z])\\1/', $password, $matches);
            return (count($matches[0]) >= 2);
        }

        function getNextPassword(string $password) : string {
            $password++;
            while (!(checkStraight($password) && checkForbidden($password) && checkPairs($password))) {
                $password++;
            }
            return $password;
        }

        return getNextPassword($input);
    }

    public static function puzzle_2015_11_2(string $input) : string {
        $input = trim($input);
        function checkStraight(string $password) : bool {
            for ($i = 0; $i < strlen($password) - 2; $i++) {
                $char = $password[$i];
                if ($char == 'z' || $char == 'y'){
                    continue;
                }
                if ($password[$i+1] == ++$char && $password[$i+2] == ++$char) {
                    return true;
                }
            }
            return false;
        }

        function checkForbidden(string $password) : bool {
            return !(str_contains($password, 'i') || str_contains($password,'l') || str_contains($password,'o'));
        }

        function checkPairs(string $password) : bool {
            $matches = [];
            preg_match_all('/([a-z])\\1/', $password, $matches);
            return (count($matches[0]) >= 2);
        }

        function getNextPassword(string $password) : string {
            $password++;
            while (!(checkStraight($password) && checkForbidden($password) && checkPairs($password))) {
                $password++;
            }
            return $password;
        }

        return getNextPassword(getNextPassword($input));
    }

    public static function puzzle_2015_12_1(string $input) : int {
        $json = json_decode($input, true);

        function deepSum($array) : int {
            $sum = 0;
            foreach($array as $item) {
                if(is_array($item)) {
                    $sum += deepSum($item);
                }
                if(is_numeric($item)) {
                    $sum += $item;
                }
            }
            return $sum;
        }

        return deepSum($json);
    }

    public static function puzzle_2015_12_2(string $input) : int {
        $json = json_decode($input, true);
        dump($json);
        function deepSum($array) : int {
            $sum = 0;
            foreach($array as $key => $item) {
                if($item == 'red' && !is_numeric($key)) {
                    return 0;
                }
                if(is_array($item)) {
                    $sum += deepSum($item);
                }
                if(is_numeric($item)) {
                    $sum += $item;
                }
            }
            return $sum;
        }

        return deepSum($json);
    }

    public static function puzzle_2015_13_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $vals = [];
        foreach ($lines as &$line) {
            if(!strlen($line)) {
                continue;
            }
            $line = trim($line, '.');
            $line = explode(' ', $line);
            $sign = $line[2] == 'lose' ? -1 : 1;
            $vals[$line[0]][$line[10]] = $sign * $line[3];
        }
        $people = array_keys($vals);

        function getOptimalHappiness($current, $locations, $visited, $adjMatrix, $first) {
            $visited[] = $current;
            $left = array_diff($locations, $visited);
            if(count($left) == 1) {
                return $adjMatrix[$current][$left[key($left)]] + $adjMatrix[$left[key($left)]][$current] + $adjMatrix[$left[key($left)]][$first] + $adjMatrix[$first][$left[key($left)]];
            }
            $routesVals = array_map(fn($arg) => $adjMatrix[$current][$arg] + $adjMatrix[$arg][$current] + getOptimalHappiness($arg, $locations, $visited, $adjMatrix, $first), $left);
            return max($routesVals);
        }

        return getOptimalHappiness($people[0], $people, [], $vals, $people[0]);
    }

    public static function puzzle_2015_13_2(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $vals = [];
        foreach ($lines as &$line) {
            if(!strlen($line)) {
                continue;
            }
            $line = trim($line, '.');
            $line = explode(' ', $line);
            $sign = $line[2] == 'lose' ? -1 : 1;
            $vals[$line[0]][$line[10]] = $sign * $line[3];
        }
        $people = array_keys($vals);
        foreach($people as $person) {
            $vals[$person]['Me'] = 0;
            $vals['Me'][$person] = 0;
        }
        $people[] = 'Me';

        function getOptimalHappiness($current, $locations, $visited, $adjMatrix, $first) {
            $visited[] = $current;
            $left = array_diff($locations, $visited);
            if(count($left) == 1) {
                return $adjMatrix[$current][$left[key($left)]] + $adjMatrix[$left[key($left)]][$current] + $adjMatrix[$left[key($left)]][$first] + $adjMatrix[$first][$left[key($left)]];
            }
            $routesVals = array_map(fn($arg) => $adjMatrix[$current][$arg] + $adjMatrix[$arg][$current] + getOptimalHappiness($arg, $locations, $visited, $adjMatrix, $first), $left);
            return max($routesVals);
        }

        return getOptimalHappiness($people[0], $people, [], $vals, $people[0]);
    }

    public static function puzzle_2015_14_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $reindeer = [];
        $time = 2503;
        $distances = [];
        foreach($lines as $key => $line) {
            if (!strlen($line)) {
                continue;
            }
            $linePcs = explode(' ', $line);
            $reindeer[$key]['speed'] = intval($linePcs[3]);
            $reindeer[$key]['moveTime'] = intval($linePcs[6]);
            $reindeer[$key]['restTime'] = intval($linePcs[13]);
            $reindeer[$key]['cycleTime'] = $reindeer[$key]['moveTime'] + $reindeer[$key]['restTime'];
        }
        foreach($reindeer as &$deer) {
            $deer['distance'] = intdiv($time, $deer['cycleTime'])*$deer['moveTime'] + min($time % $deer['cycleTime'], $deer['moveTime']);
            $distances[] = $deer['distance'] * $deer['speed'];
        }

        return max($distances);
    }

    public static function puzzle_2015_14_2(string $input) : int {

        $lines = explode(PHP_EOL, $input);
        $reindeer = [];
        $time = 2503;
        $distances = [];
        $points = [];
        foreach($lines as $key => $line) {
            if (!strlen($line)) {
                continue;
            }
            $linePcs = explode(' ', $line);
            $reindeer[$key]['speed'] = intval($linePcs[3]);
            $reindeer[$key]['moveTime'] = intval($linePcs[6]);
            $reindeer[$key]['restTime'] = intval($linePcs[13]);
            $reindeer[$key]['cycleTime'] = $reindeer[$key]['moveTime'] + $reindeer[$key]['restTime'];
        }
        foreach ($reindeer as $key => $deer) {
            $distances[$key] = 0;
            $points[$key] = 0;
        }
        for ($i = 1; $i <= $time; ++$i) {
            foreach ($reindeer as $key => $deer) {
                $moduloT = $i % $deer['cycleTime'];
                $distances[$key] += ($moduloT >= 1 && $moduloT <= $deer['moveTime']) ? $deer['speed'] : 0;
            }
            $maxsKeys = array_keys($distances, max($distances));
            foreach($maxsKeys as $key) {
                $points[$key]++;
            }
        }


        return max($points);
    }

    public static function puzzle_2015_15_1(string $input) : int {
        $lines = explode(PHP_EOL, $input);
        $capacity = [];
        $durability = [];
        $flavor = [];
        $texture = [];
        $calories = [];
        foreach ($lines as &$line) {
            if (!strlen($line)) {
                continue;
            }
            $line = explode(' ', $line);
            $capacity[] = intval(trim($line[2], ','));
            $durability[] = intval(trim($line[4], ','));
            $flavor[] = intval(trim($line[6], ','));
            $texture[] = intval(trim($line[8], ','));
            $calories[] = intval($line[10]);
        }



    }
}
