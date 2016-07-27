<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends GeneralModel
{
    const TABLE = 'role';
    protected $table = self::TABLE;
    protected $timestamps = true;
}