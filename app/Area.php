<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\GeneralModel;

class Area extends GeneralModel
{
    const TABLE = 'area';
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
