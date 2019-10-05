<?php
return [
    'origin' => env('RECAPTCHAV3_ORIGIN', 'https://www.google.com/recaptcha'),
    'sitekey' => env('MIX_GOOGLE_RECAPTCHAV3_WEB', ''),
    'secret' => env('GOOGLE_RECAPTCHAV3_SECRET', '')
];
