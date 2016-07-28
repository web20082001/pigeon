<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/28
 * Time: 10:41
 */

namespace App\Libraries\Cls;
use App;

class Area extends BaseClass
{
    private $mArea;

    function __construct(){
        $this->mArea = new App\Area();
        $this->model = $this->mArea;
    }

    function add($input){
        $this->mArea = model_update($this->mArea,$input);
        return $this->mArea->save($input);
    }
}