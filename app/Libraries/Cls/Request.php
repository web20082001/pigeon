<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/2
 * Time: 17:07
 */

namespace App\Libraries\Cls;
use App;

class Request
{
    //类
    private $clsSnoopy;
    //结果
    private $results;

    function __construct()
    {
        $this->clsSnoopy = new App\Libraries\Cls\Snoopy();
    }

    function get($url){
        $this->clsSnoopy->fetch($url);
    }

    function results(){
        $this->results = $this->clsSnoopy->results;
        return $this->results;
    }

    function status(){
        return $this->clsSnoopy->status;
    }
}