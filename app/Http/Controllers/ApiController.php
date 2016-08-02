<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App;
use App\Libraries\Cls;


class ApiController extends Controller
{

    private $clsApi;

    function __construct()
    {
        $this->clsApi = new App\Libraries\Cls\Api();
    }

    /**
     * 列表
     * @param $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index(Request $request)
    {

    }

    /**
     * 领任务订单
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {

    }

    /**
     * 保存任务订单已完成
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    }


    public function postAction(Request $request){

        //验证是否是本组的
        $input = $request->only([
            'action',
            'id',
            'code',
            'addr'
        ]);

        //动作
        $action = strtolower($input['action']);

        switch($action){
            case 'order':
                //获取订单
                return $this->getOrder($input['code']);
                break;

            case 'finish':
                //订单设置已完成
                $is_success = $this->clsApi->taskLogFinish($input['id']);
                if($is_success){
                    $resp = $this->json_success('任务订单更新成功');
                }else{
                    $resp = $this->json_error('任务订单更新失败');
                }
                return $resp;
                break;

            case 'host_proxy':

                //验证
                $validator = App\HostProxy::storeValidator($input);

                if ($validator->fails()) {
                    return redirect()->back()->withInput()->withErrors($validator);
                }

                //获取主机的代理ip
                $host_proxy = $this->clsApi->host_proxy($input['code']);
                if($host_proxy){
                    $resp = $this->json_success('代理IP获取成功',$host_proxy->toArray());
                }else{
                    $resp = $this->json_error('代理IP获取失败');
                }
                return $resp;
                break;

            case 'host_proxy_update':

                //验证
                $validator = App\HostProxy::updateValidator($input);

                if ($validator->fails()) {
                    return  $this->json_error('IP格式不正确');
                }

                //获取主机的代理ip
                $is_success = $this->clsApi->host_proxy_update($input['code'], $input['addr']);

                if($is_success){
                    $resp = $this->json_success('代理IP更新成功');
                }else{
                    $resp = $this->json_error('代理IP更新失败');
                }
                return $resp;
                break;
            default:
                break;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $del_rlt = $this->clsArea->delete($id);

        if($del_rlt){
            $rsp = $this->withSuccess(redirect()->back(), '删除成功');
        }else{
            $rsp = $this->withError(redirect()->back(), '删除失败');
        }

        return $rsp;
    }

    /**
     * 获取订单
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function getOrder($code){

        //领任务
        $task_log = $this->clsApi->getTaskLog($code);

        if(is_null($task_log)){
            $rsp = $this->json_error('暂无任务订单');
        }else if($task_log){
            $rsp = $this->json_success('任务订单获取成功',$task_log->toArray());
        }else{
            $rsp = $this->json_error($this->clsApi->getErrorMsg());
        }

        return $rsp;
    }
}