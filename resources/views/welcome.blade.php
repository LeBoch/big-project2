<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/js/app.js')
    @vite('resources/css/app.css')
    <title>Laravel</title>
</head>
<body class="h-screen overflow-y-hidden">
<div id="app"></div>
</body>
</html>
