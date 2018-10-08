<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCase extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cases';

    /**
     * Get the User that owns the case.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
