<?php
/**
 * Created by PhpStorm.
 * User: lihuan
 * Date: 15-12-12
 * Time: 下午3:29
 */

namespace App\Libraries\Cls;

use App;
use Carbon\Carbon;
use Illuminate\Support\Facades\Config;
use DB;

class Task extends BaseClass{

    private $mTask;
    private $mTaskLog;
    private $clsTaskLog;

    function __construct(){
        $this->mTask = new App\Task();
        $this->mTaskLog = new App\TaskLog();
        $this->model = $this->mTask;
    }

    function getByTaskLogIds($task_order_ids){

        //订单
        $TaskLogs = $this->mTaskLog->whereIn('id',$task_order_ids)
            ->select('task_id')->distinct()->get();

        $task_ids =[];
        $TaskLogs->each(function($item,$key) use(&$task_ids){
            $task_ids[] = $item->task_id;
        });

        if(empty($task_ids)){
            $task_ids = [0];
        }

        $query = $this->mTask->whereIn('id',$task_ids);

        return $query->get();
    }

    function getByIdNoFail($id,$with=null){

        $query = $this->mTask->where('id',$id);

        if(!is_null($with)){
            $query->with($with);
        }

        return $query->first();
    }


    function getByIds($ids){

        $query = $this->mTask->whereIn('id',$ids);

        return $query->get();
    }

    /**
     * 修改状态
     * @param $task
     * @param $state
     * @return bool
     */
    function updateState($task,$state){

        if($this->canTaskStateChange($task->state,$state)){
            $task->state = $state;
            return $task->save();
        }else{
            return false;
        }

    }

    /**
     * 只更新任务自己的信息
     * @param $task
     * @param $upItems
     * @return mixed
     */
    function updateTask($task,$upItems){

        //更新模型
        $task = model_update($task, $upItems);
        //保存
        return $task->save();
    }

    /**
     * 任务状态新老变化是否可行
     * @param $oldState
     * @param $newState
     * @return bool
     */
    function canTaskStateChange($oldState,$newState){

        # 取消
        $cancel = App\Task::CANCEL;
        # 暂停
        $pause = App\Task::PAUSE;
        # 开始
        $start = App\Task::START;
        # 完成
        $finish = App\Task::FINISH;

        # 可执行的状态
        $enable_states = [];

        if($oldState == $cancel){
            # 取消
            $enable_states = [];
        }else if ($oldState == $pause){
            # 暂停
            $enable_states = [$start];
        }else if ($oldState == $start){
            # 开始
            $enable_states = [$cancel, $pause, $finish];
        }else if ($oldState == $finish){
            # 完毕
            $enable_states = [];
        }

        # 是否在可执行列表中
        return in_array($newState,$enable_states);
    }

    function add($input){

        //开始事务
        DB::beginTransaction();

        //设置添加用户
        $input['user_id'] = $this->userId();

        //每小时pv计算
        $per_pv_spread = $this->per_pv_spread_by_per_pv($input['per_pv']);

        //转为json存储
        $input['per_pv_spread'] = json_encode($per_pv_spread, JSON_FORCE_OBJECT);

        //更新model
        $this->mTask = model_update($this->mTask,$input);

        //添加是否成功
        $task_insert = $this->mTask->save($input);

        if(!$task_insert){
            $this->error_msg = '任务数据添加失败';
            DB::rollback();
            return false;
        }

        //新增任务id
        $task_id = $this->mTask->id;

        //任务订单
        $clsTaskLog = new App\Libraries\Cls\TaskLog();

        //间隔日期
        $pass_days = $this->pass_days($this->mTask->start_time,$this->mTask->end_time);

        foreach ($pass_days as $date){

            //默认每小时pv
            foreach($per_pv_spread as $hour => $count){

                if($count > 0){

                    //指定小时
                    $date_time = date_add_seconds($date, $hour * 3600);

                    //任务订单添加
                    $add_hours_insert = $clsTaskLog->add_hours($task_id, $date_time, $count);

                    if(!$add_hours_insert){
                        $this->error_msg = '任务订单数据添加失败';
                        DB::rollback();
                        return false;
                    }
                }

            }
        }

        DB::commit();
        return true;
    }

    /**
     * 有效的每小时分布
     * @return array
     */
    function valid_hours_pv(){
        //默认pv每小时分布
        $day_hours_pv_percent = Config::get('constants.day_hours_pv_percent');

        //只取大于0的
        return array_filter ( $day_hours_pv_percent ,function($v){
            return $v > 0;
        });
    }

    /**
     * 默认每小时分布
     * @param $per_pv
     * @return array
     */
    function per_pv_spread_by_per_pv($per_pv){
        //每小时分布
        $day_hours_pv_percent = Config::get('constants.day_hours_pv_percent');

        $hours_pv = [];
        foreach($day_hours_pv_percent as $h => $p){
            $hours_pv[$h] = intval($per_pv * $p / 100);
        }
        return $hours_pv;
    }

    /**
     * 间隔日期数组
     * @param $st
     * @param $ed
     * @return array
     */
    function pass_days($st, $ed){

        //间隔几天
        $days_count = day_span($st, $ed);

        $start_time = strtotime(short_date(strtotime($st)));

        $days = [];

        foreach(range(0, $days_count) as $i){
            $days[] = short_date($start_time + (86400 * $i));
        }

        return $days;
    }

    function store_validate($input){

        //间隔几天
        $days_count = $this->pass_days($input['start_time'], $input['end_time']);


    }
}
