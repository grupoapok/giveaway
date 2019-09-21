<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
    <title></title>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col text-center">
            <h2 class="text-secondary font-weight-bolder mb-5">@lang("mail.thanks")</h2>
            <p>{{ __("mail.new_subscriber_subject", ["title" => config('app.name')]) }}</p>
            <p>
                <a href="{{ route("returning_user", $token) }}">@lang("mail.go_back_link_text")</a>
            </p>
        </div>
    </div>
</div>

</body>
</html>
