<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;
use Auth;


class TaskController extends Controller
{
    const CONTROLLER_NAME = 'task';

    private $clsTask;
    private $clsTaskIndex;
    private $clsTaskLogIndex;

    function __construct()
    {
        $this->clsTask = new App\Libraries\Cls\Task();
        $this->clsTaskIndex = new App\Libraries\Cls\TaskIndex();
        $this->clsTaskLogIndex = new App\Libraries\Cls\TaskLogIndex();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {
        $this->clsTaskIndex->search($request);

        //获取数据
        $tasks = $this->clsTaskIndex->getTasks();

        $clsTaskIndex = $this->clsTaskIndex;

        $sub_title = '任务列表';

        return view(self::CONTROLLER_NAME.'/index',compact(
            'sub_title',
            'tasks',
            'clsTaskIndex'
        ));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $sub_title = '任务列表';

        return view(self::CONTROLLER_NAME.'/create',compact(
            'sub_title'
        ));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->only(
            'name',
            'state',
            'enter_type',
            'url',
            'keyword',
            'per_pv',
            'start_time',
            'end_time'
        );

        //添加
        $add_rlt = $this->clsTask->add($input);

        if($add_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '添加成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '添加失败');
        }

        return $rsp;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $task = $this->clsTask->getById($id);

        $sub_title = '任务列表';

        return view(self::CONTROLLER_NAME.'/edit',compact(
            'sub_title',
            'id',
            'task'
        ));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->only(
            'name',
            'state',
            'start_time',
            'end_time'
        );

        $input['id'] = $id;

        $up_rlt = $this->clsTask->update($input);

        if($up_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '保存成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '保存失败');
        }

        return $rsp;
    }


    public function postAction(Request $request){

        //验证是否是本组的
        $input = $request->only(['action']);

        //动作
        $action = $input['action'];

        switch($action){
            case '':

                break;
            default:
                $rsp = $this->withError(redirect(self::CONTROLLER_NAME), '未找到对应处理程序');
                break;
        }

        return $rsp;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del_rlt = $this->clsTask->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //任务详情
        $task = $this->clsTask->getById($id,['user']);

        $this->clsTaskLogIndex->search($request);

        //获取数据
        $task_logs = $this->clsTaskLogIndex->getTaskLogs();

        $clsTaskLogIndex = $this->clsTaskLogIndex;

        $sub_title = '任务详情';

        return view(self::CONTROLLER_NAME.'/show',compact(
            'sub_title',
            'id',
            'task',
            'task_logs',
            'clsTaskLogIndex'
        ));
    }
}