<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends GeneralModel
{
    const TABLE = 'host';
    protected $table = self::TABLE;
    protected $timestamps = true;
}
