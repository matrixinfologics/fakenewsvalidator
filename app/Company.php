<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
}
