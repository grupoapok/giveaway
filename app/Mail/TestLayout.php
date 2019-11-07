<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use League\Flysystem\FileNotFoundException;

class TestLayout extends Mailable
{
    use Queueable, SerializesModels;

    public $template;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $name = 'mail.'.$this->template;

        if(view()->exists($name)){
            return $this->view($name);
        }
        throw new FileNotFoundException();
    }
}
