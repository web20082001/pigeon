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

    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'state' => 'required|numeric',
            'enter_type' => 'required|numeric',
            'url' => 'required|url',
            'keyword' => 'required',
            'per_pv' => 'required|numeric',
            'start_time' => 'required|date',
            'end_time' => 'required|date',
        ]);
    }

    public static function updateValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'state' => 'required|numeric'
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

    public function start_time_short(){
        return short_date($this->start_time);
    }

    public function end_time_short(){
        return short_date($this->end_time);
    }
}