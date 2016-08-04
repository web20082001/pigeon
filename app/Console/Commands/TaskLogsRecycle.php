<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App;

class TaskLogsRecycle extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'task_log:recycle';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'task_logs recycle';


    private $clsTaskLog;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->clsTaskLog = new App\Libraries\Cls\TaskLog();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //回收超时未完成的任务
        $recycle_count = $this->clsTaskLog->recycleTaskLogs();

        echo $recycle_count;
    }
}
