<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Discussion extends Model
{

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = ['message'];


    /**
    * Get the User that owns the discussion.
    */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * Get the Case that owns the discussion.
    */
    public function case()
    {
        return $this->belongsTo('App\NewsCase');
    }

}
