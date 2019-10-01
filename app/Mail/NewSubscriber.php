<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Crypt;

class NewSubscriber extends Mailable {
    use Queueable, SerializesModels;
    private $token;
    private $name;

    /**
     * Create a new message instance.
     *
     * @param $token
     * @param $name
     */
    public function __construct($token, $name) {
        $this->token = $token;
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build() {
        return $this->view('mail.new_subscriber')
            ->subject(__("mail.new_subscriber_subject"))
            ->with([
                "token" => Crypt::encryptString($this->token),
                "name" =>$this->name
            ]);
    }
}
