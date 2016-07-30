<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;
use Carbon\Carbon;
use DB;

class TaskLog extends BaseClass
{
    private $mTaskLog;

    function __construct(){
        $this->mTaskLog = new App\TaskLog();
        $this->model = $this->mTaskLog;
    }

    function add($input){
        $this->mTaskLog = model_update($this->mTaskLog,$input);
        return $this->mTaskLog->save($input);
    }

    /**
     * 按小时添加
     * @param $task_id
     * @param $date_time
     * @param $count
     * @return mixed
     */
    function add_hours($task_id, $date_time, $count){

        //数组
        $task_logs = [];

        foreach(range(1,$count) as $i){
            $task_logs[] = [
                'task_id' => $task_id,
                'expect_time' => $this->randomExpectTime($date_time),
                'created_at' => Carbon::now()->toDateTimeString(),
            ];
        }

        return App\TaskLog::insert($task_logs);
    }

    /**
     * 返回随机时间
     * @param $date_time
     * @return bool|string
     */
    function randomExpectTime($date_time){
        return full_date(strtotime($date_time) + mt_rand (0,  3600 - 1));
    }

    /**
     * 主机领取任务的订单
     * @param $host_id
     * @return mixed
     */
    function getTaskLog($host_id){

        //已领出未完成的
        $task_log = $this->getUnFinished($host_id);

        if($task_log){
            return $task_log;
        }else{
            //新的
            return $this->getUnStartWithQueue($host_id);
        }

    }

    /**
     * 公共查询
     * @param $query
     * @return mixed
     */
    function querySelect($query){

        $t = App\Task::TABLE;
        $tl = App\TaskLog::TABLE;

        return $query->select(DB::raw("
                $t.id,
                $t.user_id,
                $t.name,
                $t.state,
                $t.enter_type,
                $t.url,
                $t.keyword,                                
                $tl.task_id,
                $tl.expect_time,
                $tl.start_time,
                $tl.end_time,
                $tl.addr,
                $tl.host_id
            "));
    }


    function getTaskLogById($id){

        $t = App\Task::TABLE;
        $tl = App\TaskLog::TABLE;

        //先获取是否已领到未完成的
        $query = $this->mTaskLog
            ->join($t, $t . '.id', '=', $tl . '.task_id')
            ->where($tl.'.id',$id);

        return $this->querySelect($query)->first();
    }

    /**
     * 获取已领出，且未完成的
     * @param $host_id
     * @return mixed
     */
    function getUnFinished($host_id){

        $t = App\Task::TABLE;
        $tl = App\TaskLog::TABLE;

        //先获取是否已领到未完成的
        $query = $this->mTaskLog
            ->join($t, $t . '.id', '=', $tl . '.task_id')
            ->where($tl.'.host_id',$host_id)
            ->where($t.'.state',App\Task::START)
            ->whereBetween($tl.'.expect_time',[current_date_hours(), next_date_hours()])
            ->orderBy($tl.'.expect_time','asc');

        return $this->querySelect($query)->first();
    }

    /**
     * 排除获取还未开始
     * @return mixed
     */
    function getUnStartWithQueue($host_id){

        $task_log = $this->getUnStart();

        if($task_log){

            //开始事务
            DB::beginTransaction();

            //用户余额，锁定
            $task_log_locked = $this->mTaskLog->where('id',$task_log->id)->lockForUpdate()->first();

            if(is_null($task_log_locked->start_time)
                && is_null($task_log_locked->host_id)){
                //无开始时间和主机

                //更新开始时间和主机
                $task_log_locked->start_time = Carbon::now()->toDateTimeString();
                $task_log_locked->host_id = $host_id;

                if($task_log_locked->save()){
                    //保存成功
                    DB::Commit();
                    return $this->getTaskLogById($task_log->id);
                }else{
                    $this->error_msg = '任务单更新开始时间，主机编号失败';
                    //回滚
                    DB::rollback();
                    return false;
                }
            }else{
                //回滚
                $this->error_msg = '任务单更新开始时间，主机编号不为空';
                DB::rollback();
                return false;
            }
        }else{
            $this->error_msg = '没有可获取的任务订单';
            return null;
        }

    }


    /**
     * 获取还未开始，可领取的
     * @return mixed
     */
    function getUnStart(){

        $t = App\Task::TABLE;
        $tl = App\TaskLog::TABLE;

        //先获取是否已领到未完成的
        $query = $this->mTaskLog
            ->join($t, $t . '.id', '=', $tl . '.task_id')
            ->whereNull($tl.'.host_id')
            ->whereNull($tl.'.start_time')
            ->where($t.'.state',App\Task::START)
            ->whereBetween($tl.'.expect_time',[current_date_hours(), next_date_hours()])
            ->orderBy($tl.'.expect_time','asc');

        return $this->querySelect($query)->first();

    }

    /**
     * 设置已执行完毕
     * @param $id
     * @return bool
     */
    function finish($id){
        //获取任务订单
        $task_log = $this->getById($id);

        if(is_null($task_log->end_time)){
            $task_log->end_time = Carbon::now()->toDateTimeString();
            return $task_log->save();
        }else{
            //已保存成功
            return true;
        }
    }
}