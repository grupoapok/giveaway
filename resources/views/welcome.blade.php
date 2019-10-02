<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta property="og:url" content="{{ config('app.url') }}" />
    <meta property="og:type" content="website" />
    <meta property="og:title" content="{{ config('app.name')}}" />
    <meta property="og:description" content="{{ __("share.facebook", [], app()->getLocale()) }}" />
    <meta property="og:image" content="{{ asset("img/".config("giveaway.share_img_facebook")) }}" />

    <title>{{ config('app.name') }}</title>
    <link rel="stylesheet" type="text/css" href="{{ mix('/css/app.css') }}"/>
    <link rel="shortcut icon" type="image/png" href="{{ asset("img/favicon.png") }}">

    <!-- Facebook Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window,document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', {{ config('facebook.pixel_id') }} );
    </script>
    <noscript>
        <img height="1" width="1" src="https://www.facebook.com/tr?id=685215331954337&ev=PageView&noscript=1"/>
    </noscript>

</head>
<body>
<div id="app"></div>

<script src="{{ mix('/js/app.js') }}"></script>

<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId            : '{{ config('facebook.app_id') }}',
            autoLogAppEvents : true,
            status           : true,
            cookie           : true,
            xfbml            : true,
            version          : 'v4.0'
        });
    };
</script>
<script async defer src="https://connect.facebook.net/{{ str_replace('_', '-', app()->getLocale()) }}/sdk.js"></script>

</body>
</html>
