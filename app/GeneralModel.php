<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/27
 * Time: 9:56
 */

namespace App;
use Illuminate\Database\Eloquent\Model;

class GeneralModel extends Model
{
    /**
     * @return string
     */
    public function getTable()
    {
        return $this->table;
    }
}