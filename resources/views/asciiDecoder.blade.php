<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ URL::asset('css/app.css') }}" rel="preload" />

    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" />
    <script type="text/javascript" defer src="{{ URL::asset('js/app.js') }}"></script>

    <script type="text/javascript" defer src="{{ URL::asset('js/asciiDecoder.js') }}"></script>

    <title>ASCII decoder</title>
</head>
<body class="antialiased">
    <h1>ASCII decoder</h1>
    <h3>ASCII</h3>
    <textarea id="ascii-text" cols="60" rows="10"></textarea>
    <div><button id="decode-button">DECODE</button></div>
    <h3>Decoded Text</h3>
    <textarea id="decoded-text" cols="60" rows="10" disabled></textarea>
</body>
</html>
