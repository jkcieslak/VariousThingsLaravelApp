<?php

namespace App\Http\Controllers;

use App\Services\AoCService;
use App\Util\AoC\AoCException;
use App\Util\AoC\AoCFunctions;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class AoCController extends Controller
{
    private AoCService $aoCService;
    public function __construct(AoCService $aoCService) {
        $this->aoCService = $aoCService;
    }
    public function puzzleAnswer(Request $request, int $year, int $day, int $puzzle, ?bool $fetchFromAoC = true) : View {
        $aocFunctions = AoCFunctions::getInstance();

//        try {
            $input = $fetchFromAoC ? $this->aoCService->getPuzzleInput($year, $day) : $request->get('input');
            if(gettype($input) != 'string') {
                throw new BadRequestHttpException('Invalid input type: '.gettype($input).'; Expected string');
            }
//        } catch (AoCException $e) {
//            abort(422, $e);
//        }

//        try {
            $answer = $aocFunctions->getFunction($year, $day, $puzzle)($input);
//        } catch (\Exception $e) {
//            abort(422, $e);
//        }

        $title = sprintf('Advent of code: %02d/XII/%04d puzzle %d.', $day, $year, $puzzle );

        $divs = [
            [
                'header' => 'Input',
                'text' => $input,
                'type' => 'puzzleInput',
            ],
            [
                'header' => 'Code',
                'text' => $this->aoCService->getFunctionSourceCode($aocFunctions->getFunctionArray()[$year][$day][$puzzle]),
                'type' => 'code',
            ],
            [
                'header' => 'Answer',
                'text' => $answer,
                'type' => 'text',
            ]
        ];

        return view('multidivs', [
            'title' => $title,
            'divs' => $divs
        ]);
    }
}

