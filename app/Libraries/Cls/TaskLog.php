<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class TaskLog extends BaseClass
{
    private $mTaskLog;

    function __construct(){
        $this->mTaskLog = new App\TaskLog();
        $this->model = $this->mTaskLog;
    }

    function add($input){
        $this->mTaskLog = model_update($this->mTaskLog,$input);
        return $this->mTaskLog->save($input);
    }
}