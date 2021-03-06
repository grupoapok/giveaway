<?php

namespace App\Console\Commands;

use App\Mail\TestLayout;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class TestMailTemplate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test:mail-layout {email=dev+test@grupoapok.com}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Mail::to($this->argument('email'))->send(new TestLayout());
    }
}
