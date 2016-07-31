<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const TABLE = 'users';
    public $table = self::TABLE;
    public $timestamps = true;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function setDisabledAtAttribute($value)
    {
        $this->attributes['disabled_at'] = disabled_at_convert($value);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function disabled_at_text()
    {
        return disabled_at_text($this->disabled_at);
    }

    /**
     * Set the user's first name.
     *
     * @param  string  $value
     * @return string
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

}
