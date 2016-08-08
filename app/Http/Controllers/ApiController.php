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
     * 领记录
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request )
    {

    }

    /**
     * 保存记录已完成
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
            'addr',
            'port'
        ]);

        //动作
        $action = strtolower($input['action']);

        switch($action){
            case 'hour_records':
                //获取记录
                $task_logs = $this->clsApi->getHoursTaskLog();

                if($task_logs){
                    $resp = $this->json_success('记录获取成功',$task_logs->toArray());
                }else{
                    $resp = $this->json_error('记录获取失败');
                }

                return $resp;
                break;

//            case 'order':
//                //获取记录
//                return $this->getOrder($input['code']);
//                break;

            case 'host':
                //获取所有主机
                $host = new App\Libraries\Cls\Host();

                $hosts = $host->apiAll();

                if($hosts){
                    $resp = $this->json_success('主机获取成功',$hosts);
                }else{
                    $resp = $this->json_error('主机获取失败',$hosts);
                }

                return $resp;
                break;

            case 'finish':
                //记录设置已完成
                $is_success = $this->clsApi->taskLogFinish($input['id'],$input['code'],$input['addr']);

                if($is_success){
                    $resp = $this->json_success('记录更新成功');
                }else{
                    $resp = $this->json_error('记录更新失败');
                }
                return $resp;
                break;

            case 'host_proxy':

                //验证
                $validator = App\HostProxy::hostProxyValidator($input);

                if ($validator->fails()) {
                    return $this->json_error('验证未通过，请检查参数是否正确');
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

                //有参数用参数，没有参数用获取值
                $clientIp = $request->getClientIp();
                if(!isset($input['addr']) || empty($input['addr'])){
                    $input['addr'] = $clientIp;
                }

                //验证
                $validator = App\HostProxy::updateValidator($input);

                if ($validator->fails()) {
                    return  $this->json_error('IP格式不正确');
                }

                //获取主机的代理ip
                $is_success = $this->clsApi->host_proxy_update($input['code'], $input['addr'],$input['port']);

                if($is_success){
                    $resp = $this->json_success('代理IP更新成功');
                }else{
                    $resp = $this->json_error('代理IP更新失败');
                }
                return $resp;
                break;
            case 'reset_ip':
                //获取记录
                $reset_success = $this->clsApi->host_reset_ip($input['code']);

                if($reset_success){
                    $resp = $this->json_success('代理重置成功');
                }else{
                    $resp = $this->json_error('代理重置失败:'.$this->clsApi->getErrorMsg());
                }
                return $resp;

                break;

            case 'software':
                //获取记录
                $software = $this->clsApi->software($input['code']);

                if($software){
                    $software_array = $software->toArray();

                    unset($software_array['created_at']);
                    unset($software_array['updated_at']);

                    $resp = $this->json_success('软件信息获取成功',$software_array);
                }else{
                    $resp = $this->json_error('软件信息获取成功失败:'.$this->clsApi->getErrorMsg());
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
     * 获取记录
     * @param $code
     * @return \Illuminate\Http\JsonResponse
     */
    private function getOrder($code){

        //领记录
        $task_log = $this->clsApi->getTaskLog($code);

        if(is_null($task_log)){
            $rsp = $this->json_error('暂无记录');
        }else if($task_log){
            $rsp = $this->json_success('记录获取成功',$task_log->toArray());
        }else{
            $rsp = $this->json_error($this->clsApi->getErrorMsg());
        }

        return $rsp;
    }
}