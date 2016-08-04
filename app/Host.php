<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Host extends GeneralModel
{
    const TABLE = 'hosts';
    public $table = self::TABLE;
    public $timestamps = true;

    public static function storeValidator(array $data)
    {
        return Validator::make($data, [
            'username' => 'required',
            'password' => 'required',
            'memory' => 'required',
            'code' => 'required',
            'area_id' => 'required|numeric',
            'remote_addr' => 'required',
            'adsl_username' => 'required',
            'adsl_password' => 'required',
            'contact' => 'required',
            'month_fee' => 'required|numeric',
            'quarter_fee' => 'required|numeric',
            'expire_time' => 'required|date'
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


    public function expire_time_short(){
        return short_date($this->expire_time);
    }

}
