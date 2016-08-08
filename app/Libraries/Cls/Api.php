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
use Illuminate\Support\Facades\Config;

class Api extends BaseClass
{
    private $clsTaskLog;
    private $clsHost;
    private $clsHostProxy;

    function __construct(){

        $this->clsTaskLog = new App\Libraries\Cls\TaskLog();
        $this->clsHost = new App\Libraries\Cls\Host();
        $this->clsHostProxy = new App\Libraries\Cls\HostProxy();
    }

    /**
     * 获取主机id
     * @param $code
     * @return bool
     */
    function getHostId($code){

        $host_id = $this->clsHost->getHostId($code);

        if(!$host_id){
            //错误原因
            $this->error_msg = $this->clsHost->getErrorMsg();
            return false;
        }
        return $host_id;
    }

    /**
     * 获取主机id
     * @param $code
     * @return bool
     */
    function getHost($code){
        $host = $this->clsHost->getByCode($code);
        if(!$host){
            //错误原因
            $this->error_msg = '主机编号不存在';
            return false;
        }
        return $host;
    }

    /**
     * 主机领单
     * @param $host_id
     * @return mixed
     */
    function getTaskLog($code){

        $host_id = $this->getHostId($code);

        if($host_id){
            $task_log = $this->clsTaskLog->getTaskLog($host_id);

            //错误原因
            $this->error_msg = $this->clsTaskLog->getErrorMsg();

            return $task_log;
        }else{

            return false;
        }
    }

    /**
     * 获取当前小时所能可处理任务
     * @return mixed
     */
    function getHoursTaskLog(){
        return $this->clsTaskLog->getHoursUnStart();
    }

    /**
     * 订单设置已完成
     * @param $id
     * @param $addr
     * @return bool
     */
    function taskLogFinish($id,$code,$addr){

        $host_id = $this->getHostId($code);

        if($host_id) {

            return $this->clsTaskLog->finish($id,$host_id,$addr);
        }else{
            return false;
        }




    }

    /**
     * 获取主机代理ip
     * @param $host_id
     * @return mixed
     */
    function host_proxy($code){

        $host_id = $this->getHostId($code);

        if($host_id) {
            return $this->clsHostProxy->getByHostId($host_id);
        }else{
            return false;
        }
    }

    /**
     * 更新代理ip
     * @param $host_id
     * @param $addr
     * @return bool
     */
    function host_proxy_update($code, $addr, $port){

        $host = $this->getHost($code);

        if($host) {

            $host_id = $host->id;
            //代理
            $host_proxy = $this->clsHostProxy->getByHostId($host_id);

            if($host_proxy){

                return $this->clsHostProxy->updateByHostId($host_id,[
                    'addr' => $addr,
                    'port' => $port,
                    'updated_at' => Carbon::now()->toDateTimeString(),
                ]);

            }else{
                return $this->clsHostProxy->add([
                    'host_id' => $host_id,
                    'addr' => $addr,
                    'port' => $port,
                    'area_id' =>$host->area_id
                ]);
            }

        }else{
            return false;
        }
    }

    /**
     * 重置主机ip
     * @param $code
     * @return bool
     */
    function host_reset_ip($code){

        //重置主机ip链接
        $reset_url = $this->clsHost->reset_ip_url($code);

        if(!$reset_url){
            $this->error_msg = $this->clsHost->getErrorMsg();
            return false;
        }

        $reset_url = 'http://'.$reset_url.':'.Config::get('constants.reset_ip_port');
        $clsRequest = new App\Libraries\Cls\Request();
        $clsRequest->get($reset_url);

        //状态
        $status = $clsRequest->status();
        //返回内容
        $results = $clsRequest->results();

        if($status == 200 && $results == 'ok'){
            return true;
        }else{
            $this->error_msg = $clsRequest->error();
            return false;
        }
    }

    function software($code){
        $clsSoftware = new App\Libraries\Cls\Software();
        $software = $clsSoftware->getByCode($code);

        if($software){
            return $software;
        }else{
            $this->error_msg = '没有找到对应软件信息';
            return false;
        }
    }
}