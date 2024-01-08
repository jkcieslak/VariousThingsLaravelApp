<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ URL::asset('css/app.css') }}" rel="preload" />

    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" />
    <script type="text/javascript" defer src="{{ URL::asset('js/app.js') }}"></script>
{{--    HL.JS--}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>

    <!-- and it's easy to individually load additional languages -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/languages/php.min.js"></script>

    <script>hljs.highlightAll();</script>
{{--    //HL.JS--}}

    <title>{{ $title }}</title>
</head>
<body class="antialiased">
    @foreach($divs as $div)
        <h2>{{ $div['header'] }}</h2>
        @if($div['type'] == 'code')
            <div class="code"><pre><code>{{ $div['text'] }}</code></pre></div>
        @elseif($div['type'] == 'puzzleInput')
            <div><p class="puzzle-input">{{ $div['text'] }}</p></div>
        @else
            <div><p> {{ $div['text'] }}</p></div>
        @endif
    @endforeach
</body>
</html>
