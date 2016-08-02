<?php
/**
 * Created by PhpStorm.
 * User: lihuan
 * Date: 2016/1/6
 * Time: 10:25
 */

namespace App\Libraries\Cls;

use Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel as ExcelTools;

abstract class BaseClass
{
    protected $model;

    /**
     * 错误原因
     * @var
     */
    protected $error_msg;
    protected $error_msgs;
    protected $success_msgs;

    /**
     *
     * @param $query
     * @param $disabled_at
     * @param string $field
     * @return mixed
     */
    protected function disabledSearch($query,$disabled_at,$field = 'disabled_at'){

        if($disabled_at == 1){
            return $query->whereNotNull($field);
        }else if($disabled_at == 0){
            return $query->whereNull($field);
        }else{
            return $query;
        }
    }

    /**
     * 启用禁用转换
     * @param $value
     * @return null|static
     */
    public function dateDisabledTextConvert($value){

        $disabled_values = [
            '启用' => null,
            '禁用' => Carbon::now()->toDateTimeString()
        ];

        return $disabled_values[$value];
    }


    public function disabledConvert($value){

        $disabled_values = [
            '0' => null,
            '1' => Carbon::now()->toDateTimeString()
        ];

        return $disabled_values[$value];
    }

    /**
     * 判断
     * @param $val
     * @param $equal
     * @param int $true
     * @param int $false
     * @return int
     */
    public function equal($val,$equal,$true = 1,$false=0){
        return ($val == $equal) ? $true:$false;
    }

    /**
     * 获取所有
     * @return mixed
     */
    function all(){
        return $this->model->all();
    }

    /**
     * 获取单个
     * @param $id
     * @param null $with
     * @param null $fail
     * @return mixed
     */
    function getById($id,$with=null,$fail=true){

        $query = $this->model->where('id',$id);

        if(!is_null($with)){
            $query->with($with);
        }

        if($fail){
            $model = $query->firstOrFail();
        }else{
            $model = $query->first();
        }
        return $model;
    }

    /**
     * 更新
     * @param $upItems
     * @return bool
     */
    function update($upItems){

        if(array_key_exists('id',$upItems)){

            $id = $upItems['id'];
            unset($upItems['id']);

            $model = $this->getById($id);

            $model = model_update($model, $upItems);

            return $model->save();

        }else{
            return false;
        }
    }

    /**
     * 删除
     * @param $id
     * @return mixed
     */
    function delete($id){
        return $this->getById($id)->delete();
    }


    /**
     * @return mixed
     */
    public function getErrorMsgs()
    {
        return $this->error_msgs;
    }

    /**
     * @return mixed
     */
    public function getSuccessMsgs()
    {
        return $this->success_msgs;
    }
    /**
     * @return mixed
     */
    public function getErrorMsg()
    {
        return $this->error_msg;
    }

    function userId(){
        return Auth::user()->id;
    }

    function user(){
        return Auth::user();
    }
}