<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class HostProxy extends GeneralModel
{
    const TABLE = 'host_proxies';
    public $table = self::TABLE;
    public $timestamps = true;


    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'addr' => 'required|ip'
        ]);
    }

    public static function updateValidator(array $data)
    {
        return self::storeValidator($data);
    }

    public static function hostProxyValidator(array $data)
    {
        return Validator::make($data, [
            'code' => 'required'
        ]);
    }

}
