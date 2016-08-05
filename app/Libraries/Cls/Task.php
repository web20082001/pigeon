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
    private $clsTaskCollect;

    function __construct(){
        $this->mTask = new App\Task();
        $this->mTaskLog = new App\TaskLog();
        $this->cTaskCollect = new TaskCollect();
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

            //添加汇总信息
            $taskCollect = [
                'task_id'   => $task_id,
                'collect_date'  => $date,
                'per_pv' => $input['per_pv']
            ];

            $cTaskCollect = new TaskCollect();
            $taskCollect_add = $cTaskCollect->add($taskCollect);

            if(!$taskCollect_add){
                $this->error_msg = '任务汇总数据添加失败';
                DB::rollback();
                return false;
            }

            //每小时pv计算
            $per_pv_spread = $this->per_pv_spread_by_per_pv($date,$input['per_pv']);

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
    function valid_hours_pv($date){

        //默认pv每小时分布
        $day_hours_pv_percent = Config::get('constants.day_hours_pv_percent');

        //日期差
        $day_span = day_span(today(),$date,false);

        //当前小时
        $current_hours = intval(date('H'));
        //当前分钟
        $current_minutes = intval(date('i'));

        //有效小时
        $valid_hours = [];

        foreach ($day_hours_pv_percent as $hours =>$v){

            if($day_span > 0){
                //明天
            }else if($day_span == 0){
                //今天
                if($hours < $current_hours){
                    //小于当前小时，全不要
                    continue;
                }else if($hours == $current_hours){
                    //等于当前小时，大于半点的，不要
                    if ($current_minutes >= 30){
                        continue;
                    }else{
                        //小于30分的要
                    }
                }else{
                    //大于当前小时的要
                    $valid_hours[$hours] = $v;
                }
            }

            if($v > 0){
                $valid_hours[$hours] = $v;
            }
        }

        return $valid_hours;
    }

    /**
     * 默认每小时分布
     * @param $per_pv
     * @return array
     */
    function per_pv_spread_by_per_pv($date,$per_pv){

        //有效pv
        $valid_hours_pv = $this->valid_hours_pv($date);

        //未分配的数量
        $left_pv = $per_pv;

        $sum = 0;
        $hours_pv = [];
        foreach($valid_hours_pv as $h => $p){

            //分配量
            $amount = ceil(floatval($per_pv * $p / 100));

            $left_pv -= $amount;

            if($left_pv == 0){
                //分完跳出
                $hours_pv[$h] = $amount;
                break;
            }else if($left_pv < 0){
                $amount = $left_pv + abs($amount);
                $left_pv = 0;
            }

            //按比例分配量
            $hours_pv[$h] = $amount;
        }

        //还有余量
        if($left_pv > 0){
            //剩余小时平均分
            $hours_avg_count = intval(floatval($left_pv / count($valid_hours_pv)));

            //求余
            $hours_mod_count = $left_pv % count($valid_hours_pv);

            foreach ($hours_pv as $h => $v){

                if($hours_mod_count > 0){
                    //余量加到第一个小时
                    $hours_pv[$h] += $hours_mod_count;
                    $hours_mod_count = 0;
                }

                $hours_pv[$h] += $hours_avg_count;
            }
        }

        return $hours_pv;
    }

    /**
     * 默认每小时分布
     * @param $per_pv
     * @return array
     */
    function per_pv_spread_by_per_pv_origin($per_pv){
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

    /**
     * 回收超时未完成的订单
     * @return mixed
     */
    function autoFinish(){

        $t = App\Task::TABLE;

        //先获取是否已领到未完成的
        return $this->mTask
            ->where($t.'.state',App\Task::START)
            ->where($t.'.end_time','<',full_date())
            ->update([
                $t.'.state'=> App\Task::FINISH
            ]);
    }

    /**
     * 任务是否可编辑
     * @param $task
     * @return bool
     */
    function is_can_not_edit($task){
        return $task->is_can_not_edit();
    }

    function update($upItems){

        if(array_key_exists('id',$upItems)){

            $id = $upItems['id'];

            $task = $this->getById($id);

            //是否可编辑，取消和完成不可编辑
            $is_can_not_edit = $this->is_can_not_edit($task);

            if($is_can_not_edit){
                $this->error_msg = '任务状态不允许再编辑';
                return false;
            }else{
                return parent::update($upItems);
            }

        }else{
            return false;
        }


    }
}
