<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" />
    <script type="text/javascript" defer src="{{ URL::asset('js/app.js') }}"></script>

    <title>{{ $title }}</title>
</head>
<body class="antialiased">
    <div><p>{{ $oneLiner }}</p></div>
</body>
</html>
