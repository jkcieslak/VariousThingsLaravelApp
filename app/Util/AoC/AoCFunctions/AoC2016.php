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
}
