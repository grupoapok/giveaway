<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset("img/favicon.png") }}">
</head>
<body>

<div id="app"></div>

<script src="{{ mix('/js/admin.js') }}"></script>

</body>
</html>
