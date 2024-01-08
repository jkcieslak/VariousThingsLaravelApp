<?php

namespace App\Util\AoC;

use Throwable;

class AoCException extends \Exception
{
    public function __construct($message = null, $code = null, Throwable $previous = null)
    {
        parent::__construct($message ?? 'Puzzle has no solution for given input', 0, $previous);

        $this->code = $code ?: 0;
    }
}
