<?php

namespace App\Util\AoC;

use Exception;

/**
 * Singleton class containing and array of functions for AoC to call
 */
class AoCFunctions
{
    private static ?AoCFunctions $instance = null;
    private array $functionArray;
    private array $routeArray;
    const YEAR_FIRST = 2015;
    const YEAR_LAST = 2023;
    const DAY_FIRST = 1;
    const DAY_LAST = 25;
    private function __construct() {}

    private function __clone() {}

    /**
     * @throws Exception
     */
    public function __wakeup() {
        throw new Exception("Can't deserialize a singleton.");
    }
    public static function getInstance(): AoCFunctions {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->initFunctionArray();
            self::$instance->initRouteArray();
        }
        return self::$instance;
    }

    private function initFunctionArray() : void {
        for($year = AoCFunctions::YEAR_FIRST; $year <= AoCFunctions::YEAR_LAST ; $year++) {
            $classString = '\App\Util\AoC\AoCFunctions\AoC'.$year;
            for($day = AoCFunctions::DAY_FIRST; $day <= AoCFunctions::DAY_LAST; $day++) {
                for($puzzle = 1; $puzzle <= 2; $puzzle++){
                    try {
                        $functionString = 'puzzle_'.$year.'_'.$day.'_'.$puzzle;
                        $this->functionArray[$year][$day][$puzzle] = $classString::$functionString(...);
                    } catch (\Error $e){
                        continue;
                    }
                }
            }
        }
    }

    private function initRouteArray() : void {
        $this->routeArray = $this->functionArray;
        array_walk($this->routeArray, function(&$yearArr, $year) {
            array_walk($yearArr, function(&$dayArr, $day) use ($year){
                array_walk($dayArr, function(&$puzzle, $puzzleNo) use($year, $day){
                    $puzzle = route('aoc.puzzle', ['year' => $year, 'day' => $day, 'puzzle' => $puzzleNo]);
                });
            });
        });
    }

    public function getFunctionArray() : array {
        return $this->functionArray;
    }

    public function getRouteArray() : array {
        return $this->routeArray;
    }

    /**
     * @throws AoCException
     */
    public function getFunction(int $year, int $day, int $puzzle) {
        if($year < 2015 || $year >2023) {
            throw new AoCException("There are no puzzles for given year");
        }
        if($day < 1 || $day > 25) {
            throw new AoCException("There are no puzzles for given day");
        }
        if($puzzle < 1 || $puzzle > 2) {
            throw new AoCException("There are only two puzzles for a given day");
        }
        try {
            return $this->getFunctionArray()[$year][$day][$puzzle];
        } catch (\ErrorException $e) {
            throw new AoCException("Puzzle not yet implemented");
        }
    }

}
