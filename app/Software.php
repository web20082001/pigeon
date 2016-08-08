<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GeneralModel;
use Illuminate\Support\Facades\Validator;

class Software extends GeneralModel
{
    const TABLE = 'softwares';
    public $table = self::TABLE;
    public $timestamps = true;

    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'code' => 'required',
            'version' => 'required',
            'url' => 'required|url'
        ]);
    }

    public static function updateValidator(array $data)
    {
        return self::storeValidator($data);
    }
}
