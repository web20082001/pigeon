<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GeneralModel;

class Area extends GeneralModel
{
    const TABLE = 'area';
    public $table = self::TABLE;
    public $timestamps = true;
}
