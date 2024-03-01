<?php

namespace App\Util\AoC\AoCFunctions;

use App\Util\AoC\AoCException;

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
}
