<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class Role extends BaseClass
{
    private $mRole;

    function __construct(){
        $this->mRole = new App\Role();
        $this->model = $this->mRole;
    }

    function add($input){
        $this->mRole = model_update($this->mRole,$input);
        return $this->mRole->save($input);
    }
}