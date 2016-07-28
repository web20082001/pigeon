<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 17:16
 */

namespace App\Libraries\Cls;
use App;

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
}