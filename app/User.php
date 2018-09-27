<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    const ROLE_ADMIN = 'admin';
    const ROLE_COMPANY_ADMIN = 'company_admin';
    const ROLE_USER = 'user';


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
     * To check role of Admin
     *
     * @return boolean
     */
    public function isAdmin()
    {
        if ($this->role == self::ROLE_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * To check role of Admin
     *
     * @return boolean
     */
    public function isCompanyAdmin()
    {
        if ($this->role == self::ROLE_COMPANY_ADMIN) {
            return true;
        }

        return false;
    }

    /**
     * To check role of Admin
     *
     * @return boolean
     */
    public function isUser()
    {
        if ($this->role == self::ROLE_USER) {
            return true;
        }

        return false;
    }

    /**
    * return full name of user
    *
    * @return string
    */
    public function getNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
