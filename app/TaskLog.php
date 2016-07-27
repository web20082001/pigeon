<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TaskLog extends GeneralModel
{
    const TABLE = 'task_log';
    protected $table = self::TABLE;
    protected $timestamps = true;

    public function task(){
        return $this->belongsTo('App\Task');
    }
}
