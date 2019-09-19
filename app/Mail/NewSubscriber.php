<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class NewSubscriber extends Mailable {
    use Queueable, SerializesModels;
    private $token;

    /**
     * Create a new message instance.
     *
     * @param $token
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('mail.new_subscriber')
            ->subject(__("mail.new_subscriber_subject", ["title" => env("APP_NAME")]))
            ->with([
                "token" => Crypt::encryptString($this->token)
            ]);
    }
}
