<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Role extends GeneralModel
{
    const TABLE = 'roles';
    public $table = self::TABLE;
    public $timestamps = true;

    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required',
            'memo' => 'required'
        ]);
    }

    public static function updateValidator(array $data)
    {
        return self::storeValidator($data);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function setDisabledAtAttribute($value)
    {
        $this->attributes['disabled_at'] = $this->disabledAtConvert($value);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function disabled_at_text()
    {
        return $this->disabledAtText($this->disabled_at);
    }
}