<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GeneralModel;
use Illuminate\Support\Facades\Validator;

class TaskCollect extends GeneralModel
{
    const TABLE = 'task_collects';
    public $table = self::TABLE;
    public $timestamps = true;


    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'task_id' => 'required|numeric',
            'collect_date' => 'required|date',
            'per_pv' => 'required|numeric',
            'finish_count' => 'required|numeric',
        ]);
    }

    public static function updateValidator(array $data)
    {
        return self::storeValidator($data);
    }
}
