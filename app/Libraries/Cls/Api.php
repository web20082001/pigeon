<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

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
        $host = $this->clsHost->getByCode($code);
        if(!$host){
            //错误原因
            $this->error_msg = '主机编号不存在';
            return false;
        }
        return $host->id;
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
     * 订单设置已完成
     * @param $id
     * @return bool
     */
    function taskLogFinish($id){

        return $this->clsTaskLog->finish($id);

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
    function host_proxy_update($code, $addr){

        $host_id = $this->getHostId($code);

        if($host_id) {
            return $this->clsHostProxy->updateByHostId(
                $host_id,
                ['addr' => $addr]
            );
        }else{
            return false;
        }
    }
}