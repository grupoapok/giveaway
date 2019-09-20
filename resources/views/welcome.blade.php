<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta property="og:url" content="{{ env("APP_URL") }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ env("APP_NAME") }}" />
    <meta property="og:description" content="Concursa y gana una pagina web gratis" />
    <meta property="og:image" content="{{ asset("img/apok_logo.png") }}" />

    <title>{{ env("APP_NAME") }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset("img/favicon.png") }}">
</head>
<body>
<div id="app"></div>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '{{ env('FACEBOOK_API_KEY') }}',
            autoLogAppEvents : true,
            xfbml            : true,
            version          : 'v4.0'
        });
    };
</script>
<script async defer src="https://connect.facebook.net/{{ str_replace('_', '-', app()->getLocale()) }}/sdk.js"></script>
</body>
</html>
