<?php

namespace App\Services;

use App\Util\AoC\AoCException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Psr\SimpleCache\InvalidArgumentException;
use ReflectionFunction;

class AoCService
{
    private string $baseRoute = 'https://adventofcode.com/';
    private string $domain = 'adventofcode.com';
    private string $sessionCookie;
    private int $cacheLifetime = 86400;

    public function __construct() {
        $this->sessionCookie = config('app.aocSession');
    }

    /**
     * @throws AoCException
     */
    public function getPuzzleInput(int $year, int $day) : string {
        try {   //The input doesn't change, so we cache it
            if ($this->isPuzzleInputCacheSet($year, $day)){
                $puzzleInput = $this->getPuzzleInputCache($year, $day);
            } else {
                $puzzleInput = $this->fetchPuzzleInput($year, $day);
                if(!$this->setPuzzleInputCache($year, $day, $puzzleInput)) {
                    Log::warning('Unable to set cache for puzzle: '.$year.'.'.$day);
                }
            }
        } catch (InvalidArgumentException $e) {
            throw new AoCException($e);
        }

        return $puzzleInput;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function isPuzzleInputCacheSet(int $year, int $day) : bool {
        return Cache::store('redis')->has('AoC.'.$year.'.'.$day.'.input');
    }

    public function setPuzzleInputCache(int $year, int $day, string $input) : bool {
        return Cache::store('redis')->put('Aoc.'.$year.'.'.$day.'.input', $input, $this->cacheLifetime);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getPuzzleInputCache(int $year, int $day) : string {
        return Cache::store('redis')->get('Aoc.'.$year.'.'.$day.'.input');
    }

    public function fetchPuzzleInput(int $year, int $day) : string {
        return
            Http::withCookies(['session' => $this->sessionCookie], $this->domain)
            ->get($this->baseRoute.$year.'/day/'.$day.'/input')
            ->body();
    }

    public function getFunctionSourceCode(callable $callable) : string {
        try {
            $reflFunc = new ReflectionFunction($callable);
            $lines = file($reflFunc->getFileName());
            $slices = array_slice(
                $lines,
                $start = $reflFunc->getStartLine() - 1,
                $reflFunc->getEndLine() - $start,
            );
            return implode('', $slices);
        } catch (\ReflectionException $e) {
            return "Unable to retrieve function source code";
        }
    }
}
