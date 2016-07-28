<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostProxy extends GeneralModel
{
    const TABLE = 'host_proxy';
    public $table = self::TABLE;
    public $timestamps = true;
}
