<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class Software extends BaseClass
{
    private $mSoftware;

    function __construct(){
        $this->mSoftware = new App\Software();
        $this->model = $this->mSoftware;
    }

    function add($input){
        $this->mSoftware = model_update($this->mSoftware,$input);
        return $this->mSoftware->save($input);
    }

    function getByCode($code){
        return $this->mSoftware->where('code',$code)->first();
    }
}