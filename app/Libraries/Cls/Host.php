<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:16
 */

namespace App\Libraries\Cls;
use Illuminate\Support\Facades\Config;
use App;
use DB;

class Host  extends BaseClass
{
    private $mHost;

    function __construct(){
        $this->mHost = new App\Host();
        $this->model = $this->mHost;
    }

    function add($input){
        $this->mHost = model_update($this->mHost,$input);
        return $this->mHost->save($input);
    }

    function getByCode($code){
        return $this->mHost->where('code',$code)->first();
    }

    /**
     * 所有启用主机
     * @return mixed
     */
    function apiAll(){

        $h = App\Host::TABLE;
        $a = App\Area::TABLE;

        $query = $this->mHost
            ->join($a,$a.'.id','=',$h.'.area_id')
            ->whereNull($h . '.disabled_at');

        return $query->select(DB::raw("
            $h.code,
            $a.name AS area_name
        "))->get();
    }

    /**
     * 获取主机id
     * @param $code
     * @return bool
     */
    function getHostId($code){

        $host = $this->getByCode($code);

        if(!$host){
            //错误原因
            $this->error_msg = '主机编号不存在';
            return false;
        }
        return $host->id;
    }

    /**
     * 重置主机ip链接
     * @param $code
     * @return bool|null|string
     */
    function reset_ip_url($code){

        $clsHostProxy = new App\Libraries\Cls\HostProxy();

        //代理
        $host_proxy = $clsHostProxy->getByCode($code);

        if($host_proxy){

            return $host_proxy->addr;

            /*

            //主机地址
            $pattern  =  '/\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3}/' ;
            preg_match ( $pattern ,  $host_proxy->addr ,  $matches);

            if($matches){
                return 'http://'.$matches[0].':'.Config::get('constants.reset_ip_port');
            }else{
                $this->error_msg = '匹配代理IP失败';
                return false;
            }
            */

        }else{
            $this->error_msg = '没有该主机代理信息';
            return null;
        }

    }
}