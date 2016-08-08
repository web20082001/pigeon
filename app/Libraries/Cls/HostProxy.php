<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:16
 */

namespace App\Libraries\Cls;
use App;
use DB;

class HostProxy extends BaseClass
{
    private $mHostProxy;

    function __construct(){
        $this->mHostProxy = new App\HostProxy();
        $this->model = $this->mHostProxy;
    }

    function add($input){

        $this->mHostProxy = model_update($this->mHostProxy,$input);
        return $this->mHostProxy->save($input);
    }


    function getByHostId($host_id){

        $h = App\Host::TABLE;
        $hp = App\HostProxy::TABLE;
        $a = App\Area::TABLE;

        return $this->mHostProxy
            ->join($h,$h.'.id','=',$hp.'.host_id')
            ->join($a,$a.'.id','=',$h.'.area_id')
            ->where($hp.'.host_id',$host_id)
            ->select(DB::raw("
                $h.code,
                $hp.addr,
                $hp.port,
                $a.name AS area_name,
                $hp.updated_at            
            "))
            ->first();
    }

    function updateByHostId($host_id,$upItems){
        return $this->mHostProxy->where('host_id',$host_id)
            ->update($upItems);
    }

    function getByCode($code){

        $clsHost = new App\Libraries\Cls\Host();

        $host_id = $clsHost->getHostId($code);

        if($host_id) {
            return $this->getByHostId($host_id);
        }else{
            return false;
        }
    }
}