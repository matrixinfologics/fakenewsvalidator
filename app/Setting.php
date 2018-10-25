<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Setting extends Model
{
    const TYPE_TWITTER_CONSUMER_KEY = 'twitter_consumer_key';
    const TYPE_TWITTER_CONSUMER_SECRET = 'twitter_consumer_secret';
    const TYPE_TWITTER_ACCESS_TOKEN = 'twitter_access_token';
    const TYPE_TWITTER_ACCESS_TOKEN_SECRET = 'twitter_access_token_secret';
    const TYPE_TINEYE_PRIVATE_KEY = 'tineye_private_key';
    const TYPE_TINEYE_PUBLIC_KEY = 'tineye_public_key';

    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', 'value'
    ];

     /**
     * Get Setting types as array
     *
     * @return array
     */
    public function getSettingTypes()
    {
        $prefix = 'TYPE_';
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

    /**
     * Find Setting by key
     *
     * @param string $key
     * @return Setting
     */
    public function findByKey($key){
        return Setting::where('key', '=', $key)->first();
    }

     /**
     * get Setting value by key
     *
     * @param string $key
     * @return string
     */
    public function getSettingValueByKey($key){
        return $this->findByKey($key)->value;
    }
}
