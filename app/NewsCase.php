<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NewsCase extends Model
{
    const SECTION_INFO = 1;
    const SECTION_POST_ANALYSIS = 2;
    const SECTION_REPLIES = 3;
    const SECTION_AUTHOR_PROFILE = 4;
    const SECTION_AUTHOR_LATEST_POSTS = 5;
    const SECTION_POST_GEO_LOCATIONS = 6;
    const SECTION_SIMILAR_POSTS = 7;
    const SECTION_SIMILAR_POSTS_SAME_AREA = 8;
    const SECTION_IMAGE_SEARCH = 9;
    const SECTION_SOURCE_CROSSS_CHECKING = 10;
    const SECTION_DISCUSSION = 11;

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
