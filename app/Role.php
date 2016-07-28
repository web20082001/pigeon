<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends GeneralModel
{
    const TABLE = 'role';
    public $table = self::TABLE;
    public $timestamps = true;

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