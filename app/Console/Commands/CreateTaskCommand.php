<?php

namespace App\Console\Commands;

use App\Task;
use Illuminate\Console\Command;

class CreateTaskCommand extends Command {
    protected $signature = 'make:task {--type=} {--tickets=} {--url=} {--repeat} {--auto}';

    protected $description = 'Create new task for users to complete';

    public function __construct() {
        parent::__construct();
    }

    public function handle() {
        $type = $this->getType();
        $tickets = $this->getTickets();

        $repeatable = $this->getRepeatable();

        $confirm_type = $this->getConfirmType();

        if ($type == "form") {
            $url = $this->getUrl();
        } else {
            $url = "";
        }

        $description = "";

        if ($tickets > 0) {
            Task::create(compact("type", "repeatable", "confirm_type", "url", "description", "tickets"));
        } else {
            $this->error("Must specify number of tickets to give away");
        }
    }

    private function getType() {
        $typeArg = $this->option("type");
        $options = [
            "twitter",
            "facebook",
            "linkedin",
            "instagram",
            "form"
        ];
        if ($typeArg == "" || !in_array($this->option("type"), $options)) {
            return $this->choice("Type of task", $options, 0);
        } else if (in_array($this->option("type"), $options)) {
            return $typeArg;
        } else {
            return "";
        }
    }

    private function getTickets() {
        $ticketsArg = $this->option("tickets");
        if ($ticketsArg == "" || is_null($ticketsArg) || !is_numeric($ticketsArg) || $ticketsArg=="0") {
            $ticketsArg = 0;
        }
        if ($ticketsArg == 0) {
            $tickets = $this->ask("Amount of tickets to give on completion: ", "1");
            if (!is_numeric($tickets)) {
                $tickets = 0;
            }
            return $tickets;
        } else {
            return $ticketsArg;
        }
    }

    private function getRepeatable() {
        $repeatArg = $this->option("repeat");
        if ($repeatArg == "") {
            return $this->choice("Is the task repeatable?", ["Yes", "No"], 0) == "Yes";
        } else {
            return $repeatArg;
        }
    }

    private function getConfirmType() {
        $confirmArg = $this->option("auto");
        if ($confirmArg == "") {
            return strtolower($this->choice("Type of confirmation", ["Auto", "Manual"], 0));
        } else {
            return $confirmArg;
        }
    }

    private function getUrl() {
        $urlArg = $this->option("url");
        if ($urlArg == "") {
            return $this->ask("Url of the form: ");
        } else {
            return $urlArg;
        }
    }
}
