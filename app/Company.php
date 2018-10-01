<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;

class Company extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'companies';


    /**
     * Get users of company.
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

     /**
    * return full name of user
    *
    * @return string
    */
    public function getCompanyAdminAttribute()
    {
        return $this->users->where('role', User::ROLE_COMPANY_ADMIN)->first();
    }
}
