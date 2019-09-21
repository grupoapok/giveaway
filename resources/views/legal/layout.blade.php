<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>{{ env("APP_NAME") }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/legal.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset("img/favicon.png") }}">
</head>
<body>

<div class="legal container">
    <div id="cuadros" class="d-none d-lg-block">
        <div id="azul_oscuro"></div>
        <div id="azul_claro"></div>
        <div id="blanco"></div>
        <div id="azul_oscuro2"></div>
        <div id="naranja"></div>
    </div>
    <div class="row">
            <div class="col text-center text-sm-right p-5"><img src="../img/apok_logo.png" id="logo"></div>
    </div>
    <div class="row" id="main_row">
        <div class="col-12 col-lg">
            <div class="layout bg">



                <div class="fluid-container" id="main">

                    <div class="row">
                        @yield('content')
                    </div>

                    <div class="col" id="social-links-container">
                        <social-links id="social-links" :class="alignRight && 'right'"></social-links>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</body>
</html>
