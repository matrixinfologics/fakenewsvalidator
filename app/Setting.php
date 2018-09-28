<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Setting extends Model
{
    const TYPE_TWITTER_SECRET_KEY = 'twitter_secret_key';
    const TYPE_TWITTER_PRIVATE_KEY = 'twitter_private_key';

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
