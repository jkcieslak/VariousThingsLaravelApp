<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Http;
use Illuminate\View\View;

class CatFactController extends Controller
{
    public function catFact() : View
    {
        $response = Http::get('https://catfact.ninja/fact');
//        dd($response);
        return view('oneliner', ['title' => 'Random Cat Fact', 'oneLiner' => $response->json()['fact']]);
    }

    public function catFacts() : JsonResponse
    {
        $response = Http::get('https://catfact.ninja/facts');
//        dd($response);
        return new JsonResponse($response->json());
    }

    public function catBreeds() : JsonResponse
    {
        $response = Http::get('https://catfact.ninja/breeds');
//        dd($response);
        return new JsonResponse($response->json());
    }

}
