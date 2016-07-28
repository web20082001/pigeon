<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:16
 */

namespace App\Libraries\Cls;
use App;

class HostProxy  extends BaseClass
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
}