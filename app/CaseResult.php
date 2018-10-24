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
}
