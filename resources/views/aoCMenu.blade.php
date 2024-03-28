<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])

    <link href="{{ URL::asset('css/app.css') }}" rel="preload" />

    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" />
    <script type="text/javascript" defer src="{{ URL::asset('js/app.js') }}"></script>

    <title>{{ $title }}</title>
</head>
<body class="antialiased">
    <h1>Advent of Code</h1>
    @foreach ($navTree as $year => $days)
        <div style="margin-bottom: 10px">
            <button class="btn btn-outline-secondary btn-lg" type="button" data-bs-toggle="collapse" data-bs-target="#collapseYear-{{$year}}" aria-expanded="false" aria-controls="collapseYear-{{$year}}">
                {{ $year }}
            </button>
            <div class="collapse" id="collapseYear-{{$year}}">
                @foreach ($days as $day => $puzzles)
                    <div style="margin-bottom: 5px">
                        <div class="btn btn-outline-secondary btn-sm" type="button" data-bs-toggle="collapse" data-bs-target="#collapseDay-{{$year.$day}}" aria-expanded="false" aria-controls="collapseDay-{{$year.$day}}">
                            {{ $day }}
                        </div>
                        <span class="collapse" id="collapseDay-{{$year.$day}}">
                            @foreach ($puzzles as $puzzle => $link)
                                <a class="btn btn-outline-primary btn-sm" href="{{$link}}" style="margin-left: 10px;">{{ 'Puzzle '.$puzzle }}</a>
                            @endforeach
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
    @endforeach
</body>
</html>
