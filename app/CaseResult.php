<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseResult extends Model
{

     /**
     * Get Case of Result
     */
    public function case()
    {
        return $this->belongsTo('App\NewsCase');
    }

    /**
    * Get the User that owns the case.
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
