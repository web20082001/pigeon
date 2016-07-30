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
    private $clsHostProxy;

    function __construct(){
        $this->clsTaskLog = new App\Libraries\Cls\TaskLog();
        $this->clsHostProxy = new App\Libraries\Cls\HostProxy();
    }

    /**
     * 主机领单
     * @param $host_id
     * @return mixed
     */
    function getTaskLog($host_id){

        $task_log = $this->clsTaskLog->getTaskLog($host_id);

        //错误原因
        $this->error_msg = $this->clsTaskLog->getErrorMsg();

        return $task_log;

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
    function host_proxy($host_id){
        return $this->clsHostProxy->getByHostId($host_id);
    }

    /**
     * 更新代理ip
     * @param $host_id
     * @param $addr
     * @return bool
     */
    function host_proxy_update($host_id, $addr){
        return $this->clsHostProxy->updateByHostId(
            $host_id,
            ['addr' => $addr]
        );
    }
}