<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;
use Lang;

class Task extends GeneralModel
{
    const TABLE = 'task';
    public $table = self::TABLE;
    public $timestamps = true;

    # 任务状态
    const CANCEL = 1;
    const PAUSE = 2;
    const START = 3;
    const FINISH = 4;

    public static function validator(array $data)
    {
        return Validator::make($data, [
            'user_id' => 'required|numeric',
            'name' => 'required',
            'state' => 'required|numeric',
            'enter_type' => 'required|numeric',
            'url' => 'required',
            'keyword' => 'required',
            'per_pv' => 'required|numeric',
            'per_pv_spread' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
        ]);
    }

    /**
     * Get the post that owns the comment.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function task_log(){
        return $this->hasMany('App\TaskLog','task_id');
    }

    public function state_text()
    {
        return Lang::get('models.task.state.'.$this->state);
    }

    public function enter_type_text()
    {
        return Lang::get('models.task.enter_type.'.$this->enter_type);
    }
}