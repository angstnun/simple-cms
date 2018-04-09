<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class createPageController extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:make-page-controller {page}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Creates indicated page controller';

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
       $this->call('make:cms-controller', ['name' => "Home\\" . $this->argument('page') . 'Controller']);
    }
}
