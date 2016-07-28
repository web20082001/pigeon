<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends GeneralModel
{
    const TABLE = 'task_log';
    public $table = self::TABLE;
    public $timestamps = true;

    public function task(){
        return $this->belongsTo('App\Task');
    }
}
