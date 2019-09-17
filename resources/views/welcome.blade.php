<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta property="og:url" content="{{ env("APP_URL") }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title"  content="Apok Winners" />
    <meta property="og:description"        content="Concursa y gana una pagina web gratis" />
    <meta property="og:image"              content="{{ asset("img/apok_logo.png") }}" />

    <title>Apök</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>

</head>
<body>

<div id="app"></div>

<script src="{{ mix('/js/app.js') }}"></script>
<script type="text/javascript" async src="https://platform.twitter.com/widgets.js"></script>

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
<script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
</body>
</html>