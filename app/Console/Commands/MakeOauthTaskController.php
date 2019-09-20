<?php

namespace App\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand;

class MakeOauthTaskController extends ControllerMakeCommand {
    protected $name = 'make:oauthtask';

    protected $description = 'Creates a new controller for tasks that use oauth';

    protected function getStub() {
        return app_path('Console/stubs').'/oauthcontroller.stub';
    }

    protected function getDefaultNamespace($rootNamespace) {
        return $rootNamespace.'\Http\Controllers\OAuth';
    }
}
