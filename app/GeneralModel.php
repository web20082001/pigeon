<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 9:56
 */

namespace App;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class GeneralModel extends Model
{
    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }

    public function disabledAtConvert($value){

        $disabled_values = [
            '0' => null,
            '1' => Carbon::now()->toDateTimeString()
        ];

        return $disabled_values[$value];
    }


    public function disabledAtText($value,$color=true){

        $val = is_null($value) ? '启用':'禁用';
        $class = $color ? (is_null($value) ? 'green':'red'):'';

        return sprintf("<span class=\"{$class}\">{$val}</span>");
    }
}