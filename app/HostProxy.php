<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HostProxy extends GeneralModel
{
    const TABLE = 'host_proxy';
    protected $table = self::TABLE;
    protected $timestamps = true;
}
