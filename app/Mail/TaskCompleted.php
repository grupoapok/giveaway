<?php

namespace App\Mail;

use App\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TaskCompleted extends Mailable {
    use Queueable, SerializesModels;
    private $task;
    private $totalTickets;

    public function __construct(Task $task, $totalTickets, $locale) {
        $this->task = $task;
        $this->totalTickets = $totalTickets;
        $this->locale = $locale;
    }

    public function build() {
        return $this->view('mail.task_completed')
            ->subject(__("mail.task_completed_subject"))
            ->with([
                "locale" => $this->locale,
                "task" => $this->task,
                "totalTickets" => $this->totalTickets
            ]);
    }
}
