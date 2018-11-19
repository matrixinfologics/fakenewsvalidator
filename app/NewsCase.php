<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class NewsCase extends Model
{
    const FLAG_FAKE = 'fake';
    const FLAG_TRUSTED = 'trusted';
    const FLAG_IN_ANALYSIS = 'in_analysis';

    const SECTION_INFO = 1;
    const SECTION_POST_ANALYSIS = 2;
    const SECTION_REPLIES = 3;
    const SECTION_AUTHOR_PROFILE = 4;
    const SECTION_AUTHOR_LATEST_POSTS = 5;
    const SECTION_POST_GEO_LOCATION = 6;
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
    * return full name of user
    *
    * @return string
    */
    public function getFlagStatusAttribute()
    {
        switch ($this->flag) {
            case self::FLAG_FAKE:
                $flag = "Fake";
                break;

            case self::FLAG_TRUSTED:
                $flag = "Trusted";
                break;

            default:
                $flag = "In Analysis";
                break;
        }

        return $flag;
    }


    /**
     * Get the User that owns the case.
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
    * Get discussions of case.
    */
    public function discussions()
    {
        return $this->hasMany('App\Discussion', 'case_id');
    }

    /**
    * Get results of case.
    */
    public function results()
    {
        return $this->hasMany('App\CaseResult', 'case_id');
    }

    /**
    * Get section results of case.
    */
    public function sectionFakeResults()
    {
        return $this->hasMany('App\CaseSectionResult', 'case_id')->where('flag', self::FLAG_FAKE);
    }

    /**
    * Get section results of case.
    */
    public function sectionTrustedResults()
    {
        return $this->hasMany('App\CaseSectionResult', 'case_id')->where('flag', self::FLAG_TRUSTED);
    }

    /**
    * Get Setting types as array
    *
    * @return array
    */
    public function getSections()
    {
        $prefix = 'SECTION_';
        $reflection = new ReflectionClass(self::class);
        $constants  = $reflection->getConstants();

        $prefixLength = strlen($prefix);
        $options      = [];
        foreach ($constants as $name => $value) {
            if (substr($name, 0, $prefixLength) === $prefix) {
                $enumOptionName = ucwords(strtolower(str_replace('_', ' ', substr($name, $prefixLength))));
                $options[$value] = $enumOptionName;
            }
        }

        return $options;
    }

}
