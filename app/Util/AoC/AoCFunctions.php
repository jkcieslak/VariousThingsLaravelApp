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
        }
        return self::$instance;
    }

    private function initFunctionArray() : void {
//        $this->functionArray[2015][1][1] = \App\Util\AoC\AoCFunctions\AoC2015::puzzle_2015_1_1(...);

        for($year = 2015; $year <= 2023 ; $year++) {
            $classString = '\App\Util\AoC\AoCFunctions\AoC'.$year;
            for($day = 1; $day <= 25; $day++) {
                for($puzzle = 1; $puzzle <= 2; $puzzle++){
                    try {
                        $functionString = 'puzzle_'.$year.'_'.$day.'_'.$puzzle;
                        $this->functionArray[$year][$day][$puzzle] = $classString::$functionString(...); //This could raise some eyebrows
                    } catch (\Error $e){
                        continue;
                    }
                }
            }
        }
    }

    public function getFunctionArray() : array {
        return $this->functionArray;
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
