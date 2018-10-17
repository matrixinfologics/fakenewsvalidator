<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CaseSectionResult extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'case_section_results';

    /**
     * Get the User that owns the case.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
