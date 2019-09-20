<?php

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
                "description" => "Si publicas el sorteo en tu Twitter tendrás 3 tickets para el sorteo",
                "type" => "twitter",
                "repeatable" => true,
                "tickets" => 3
            ],
            [
                "description" => "Si publicas el sorteo en tu Facebook tendrás 4 tickets para el sorteo",
                "type" => "facebook",
                "repeatable" => true,
                "tickets" => 4
            ],
            [
                "description" => "Si publicas el sorteo en tu LinkedIn tendrás 5 tickets para el sorteo",
                "type" => "linkedin",
                "tickets" => 5
            ],
            [
                "description" => "",
                "repeatable" => false,
                "type" => "form",
                "tickets" => 2
            ],
        ];
        foreach($tasks as $t){
            \App\Task::create($t);
        }
    }
}
