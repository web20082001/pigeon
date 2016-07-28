<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Host extends GeneralModel
{
    const TABLE = 'host';
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
