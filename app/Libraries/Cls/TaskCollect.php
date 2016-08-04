<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class TaskCollect extends BaseClass
{
    private $mTaskCollect;

    function __construct(){
        $this->mTaskCollect = new App\TaskCollect();
        $this->model = $this->mTaskCollect;
    }

    function add($input){
        $this->mTaskCollect = model_update($this->mTaskCollect,$input);
        return $this->mTaskCollect->save($input);
    }

    /**
     * 更新已完成数量
     * @param $task_id
     * @return mixed
     */
    function finishIncrease($task_id){

        return $this->mTaskCollect->where('task_id',$task_id)
            ->where('collect_date',short_date())
            ->increment('finish_count');
    }

    /**
     * 昨日完成pv
     * @param $tasks
     * @return array
     */
    function yesterday_task_collect($tasks){

        $task_ids = [];
        $tasks->each(function($task) use(&$task_ids){
            $task_ids[] = $task->id;
        });

        if(empty($task_ids)){
            return [];
        }

        $task_collects = $this->mTaskCollect
            ->where('collect_date',yesterday())
            ->whereIn('task_id',$task_ids)
            ->select("task_id","finish_count")
            ->get();

        //映射一下
        $collect_map = [];

        foreach($task_collects as $c){
            $collect_map[$c->task_id] = $c->finish_count;
        }

        return $collect_map;
    }
}