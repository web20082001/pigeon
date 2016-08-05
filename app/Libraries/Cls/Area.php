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

    /**
     * 排序最大值
     */
    function order_sort_max(){

        $area = $this->mArea->orderBy('order_sort', 'desc')->first();

        $max = 0;

        if($area){
            $max = intval($area->order_sort);
        }

        return $max;
    }

    function all_level()
    {
        //$this->all()
    }

    /**
     * 所有可用省
     */
    function provinces()
    {
        return $this->mArea
            ->where('parent_id','=',0)
            ->whereNull('disabled_at')
            ->orderBy('id','asc')
            ->get();
    }

    /**
     * 所有可用城市
     */
    function cities()
    {
        return $this->mArea
            ->where('parent_id','>',0)
            ->whereNull('disabled_at')
            ->orderBy('id','asc')
            ->get();
    }
}