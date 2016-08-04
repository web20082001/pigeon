<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;

class TaskAutoFinish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task:finish';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'auto finish tasks';


    private $clsTask;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->clsTask = new App\Libraries\Cls\Task();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //回收超时未完成的任务
        $count = $this->clsTask->autoFinish();

        echo $count;
    }
}
