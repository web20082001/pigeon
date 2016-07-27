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

class Task extends BaseClass{

    private $mTask;
    private $mTaskLog;
    private $clsTaskLog;

    /**
     * 错误原因
     * @var
     */
    private $error_msg;

    /**
     * @return mixed
     */
    public function getErrorMsgs()
    {
        return $this->error_msgs;
    }

    /**
     * @return mixed
     */
    public function getSuccessMsgs()
    {
        return $this->success_msgs;
    }

    private $error_msgs;
    private $success_msgs;

    /**
     * @return mixed
     */
    public function getErrorMsg()
    {
        return $this->error_msg;
    }

    function __construct(){
        $this->mTask = new App\Task();
        $this->mTaskLog = new App\TaskLog();
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

    function getById($id,$with=null){

        $query = $this->mTask->where('id',$id);

        if(!is_null($with)){
            $query->with($with);
        }

        return $query->firstOrFail();
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
     * 更新任务
     * @param $id
     * @param $upItems
     */
    function updateById($id,$upItems){

        //获取任务
        $task = $this->getById($id);

        //任务新老状态
        $oldState = $task->state;
        $newState = $upItems['state'];


        //2 @todo_finished 修改任务开始结束时间是否正确判断

        //开始结束时间
        $begin_time = trim($upItems['begin_time']);
        $end_time   = trim($upItems['end_time']);


        //如果更新了任务开始时间,则重新分配佳时
        if($begin_time != $task->begin_time){

            //修改了开始时间
            if($begin_time == ''){
                $post['begin_time'] = null;
            }

            if($end_time == ''){
                $post['end_time']   = null;
            }

            //非取消状态
            if($newState != App\Task::TS_CANCEL){
                if($begin_time == ''|| $end_time == ''){
                    $this->error_msg = '开始结束时间不得为空，如果客户未设置开始时间，请谨慎操作';
                    return false;
                }
            }

            //开始时间不得大于结束时间
            if(strtotime($begin_time) > strtotime($end_time)){
                $this->error_msg = '开始时间不得大于结束时间';
                return false;
            }

            //修改了开始时间,且原先是未开始状态
            if(($task->begin_time != $begin_time) && ($oldState == App\Task::TS_UNSTART)){

                //旧开始日期，年月日
                $from_date = substr($task->begin_time,0,10);

                //新开始日期，年月日
                $to_date   = substr($begin_time,0,10);

                //订单类
                $clsTaskLog = new TaskLog();

                //修改到其它的日期，不是今天
                if($to_date != date('Y-m-d')){

                    //只批量修改预计时间替换即可

                    $up_afts = $clsTaskLog->updateExpectOrderTime($id,$from_date,$to_date);

                    if($up_afts){
                        $this->success_msgs[] = '共'.$up_afts.'个订单预计分配时间修改成功';
                    }else{
                        $this->error_msgs[] = '订单预计分配时间修改失败';
                    }

                }else{
                    //修改到今天，清除分配的时间，可重新协调
                    $up_afts = $clsTaskLog->updateExpectOrderTimeNull($id);

                    if($up_afts){
                        $this->success_msgs[] = '共'.$up_afts.'个订单预计分配时间清空成功';
                    }else{
                        $this->error_msgs[] = '订单预计分配时间清空失败';
                    }
                }
            }
        }


        //1 @todo_finished 任务之间的状态切换是否正确判断
        if($oldState != $newState){

            //如果更新了任务的状态,判断是否可修改
            $canTaskStateChange = $this->canTaskStateChange($oldState,$newState);

            if(!$canTaskStateChange){
                $this->error_msg = '任务状态修改不正确';
                return false;
            }
        }

        //4 从未开始到取消

        //从未开始，设置为取消
        if($oldState == App\Task::TS_UNSTART && ($newState == App\Task::TS_CANCEL)) {

            //  @todo_finished 如果用户是已付款，需要退款到余额，添加退款记录
            $cancelAfts = $this->cancel($task);

            if(!$cancelAfts){
                return false;
            }
        }


        //从未开始，设置为取消
        if($oldState != App\Task::TS_FINISH && ($newState == App\Task::TS_FINISH)) {

            //  @todo_ok 判断任务是否可执行完毕
            $canSetFinish = $this->canSetFinish($id);

            if(!$canSetFinish){
                $this->error_msg = '请检查任务是否正在未执行完毕或没有配快递号的订单';
                return false;
            }

        }

        //只更新任务自己的信息，不更新任务时间
        $upTaskAfts = $this->updateTask($task,$upItems);

        return $upTaskAfts;
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
}