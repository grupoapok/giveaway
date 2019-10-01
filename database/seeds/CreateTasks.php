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
                "repeatable" => false,
                "tickets" => 2,
                "order" => 1,
                "confirm_type"=>'auto'
            ],
            [
                "description" => "",
                "type" => "facebook",
                "repeatable" => false,
                "tickets" => 2,
                "order" => 2,
                "confirm_type"=>'auto'
            ],
            [
                "description" => "",
                "type" => "linkedin",
                "repeatable" => false,
                "tickets" => 5,
                "order" => 3,
                "confirm_type"=>'auto'
            ],
            [
                "description" => "",
                "type" => "instagram",
                "tickets" => 2,
                "repeatable" => false,
                "order" => 4,
                "confirm_type" => "manual"
            ],
            [
                "description" => "",
                "repeatable" => false,
                "type" => "form",
                "tickets" => 2,
                 "order" => 5,
                "url" => 'https://docs.google.com/forms/d/e/1FAIpQLSeNeIEz6qjQBPQoFrOSSZORzmf6YpUfEaQxDdyZ4WDoZBy3gg/viewform?usp=pp_url&entry.34967049=:email',
                "confirm_type"=>'auto',
                "extras"=> '[{"name": "username", "label": "Instagram Username"}]'
            ],
        ];
        foreach($tasks as $t) {
            Task::create($t);
        }
    }
}
