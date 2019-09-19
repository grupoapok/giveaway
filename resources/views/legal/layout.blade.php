<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ env("APP_NAME") }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset("img/favicon.png") }}">
</head>
<body>

<div id="info">
    <div class="row" id="main_row" :class="[grow && 'flex-grow-1']">
        <div class="col-12 col-lg" id="left">
            <slot name="col1"/>
        </div>
        <div class="col-12 col-lg my-5 my-lg-0" id="right">
            <slot name="col2"/>
        </div>
    </div>
</div>
</body>
</html>
