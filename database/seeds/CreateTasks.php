<?php

use App\Task;
use Illuminate\Database\Seeder;

class CreateTasks extends Seeder {
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run() {
        $tasks = [
            [
                "description" => "",
                "type" => "twitter",
                "repeatable" => true,
                "tickets" => 3
            ],
            [
                "description" => "",
                "type" => "facebook",
                "repeatable" => false,
                "tickets" => 4
            ],
            [
                "description" => "",
                "type" => "linkedin",
                "repeatable" => false,
                "tickets" => 5
            ],
            [
                "description" => "",
                "type" => "instagram",
                "tickets" => 2,
                "repeatable" => false,
                "confirm_type" => "manual"
            ],
            [
                "description" => "",
                "repeatable" => false,
                "type" => "form",
                "tickets" => 2
            ],
        ];
        foreach($tasks as $t) {
            Task::create($t);
        }
    }
}
