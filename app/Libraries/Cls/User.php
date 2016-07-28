<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class User extends BaseClass
{
    private $mUser;

    function __construct(){
        $this->mUser = new App\User();
        $this->model = $this->mUser;
    }

    function add($input){
        $this->mUser = model_update($this->mUser,$input);
        return $this->mUser->save($input);
    }
}