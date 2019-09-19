<!DOCTYPE html>
<html lang="{{ $locale }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}"/>
</head>
<body>

<div class="container">
    <div class="row">
        <div class="col text-center">
            <h2 class="text-secondary font-weight-bolder mb-5">@lang("mail.thanks")</h2>
            <p>
                @lang("mail.message", [
                    "type" => $task->type,
                    "newTickets" => $task->tickets,
                    "totalTickets" => $totalTickets
                ])
            </p>
        </div>
    </div>
</div>

</body>
</html>