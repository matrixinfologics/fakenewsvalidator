<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use Auth;
use Thujohn\Twitter\Twitter as twitterConfig;
use Twitter;
use RunTimeException;

class TwitterManager
{
    /** @var Company */
    private $company;

    /** @var twitterConfig */
    private $twitterConfig;

    /**
     * TwitterManager Consturctor
     *
     * @param Company $company
     * @param twitterConfig $twitterConfig
     */
    public function __construct(Company $company, twitterConfig $twitterConfig)
    {
        $this->company = $company;
        $this->twitterConfig = $twitterConfig;
    }

    /**
     * Set config of twitter
     *
     * @param array $config
     */
    public function setConfig($config){
         $this->twitterConfig->reconfig($config);
    }

    /**
     * Verify tweet with tweet Id
     *
     * @param string|int $tweetId
     */
    public function verifyTweet($tweetId){
        try{
            return Twitter::getTweet($tweetId);
        } catch (RunTimeException $e) {
            return false;
        }
    }

    /**
     * Verify tweet with tweet Id
     *
     * @param string $tweetUrl
     */
    public function getTweetPreview($tweetUrl){
        try{
            $tweet = Twitter::getOembed(['url' => $tweetUrl, 'hide_media' => true]);
            return $tweet->html;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }
}
