<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\NewsCase;
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
     * @return string|object
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
     * @return string
     */
    public function getTweetPreview($tweetUrl){
        try{
            $tweet = Twitter::getOembed(['url' => $tweetUrl, 'hide_media' => true]);
            return $tweet->html;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }

    /**
     * get latest posts of author
     *
     * @param string $author
     * @return array
     */
    public function getAuthorPosts($author){
        try{
            $tweets = Twitter::getUserTimeline(['screen_name' => $author, 'count' => 15, 'exclude_replies'=> true, 'include_rts' => false]);

            $authorPosts = [];
            $i = 0;
            foreach ($tweets as $key => $tweet) {

                if($i == 5)
                    continue;

                $url = 'https://twitter.com/'.$author.'/status/'.$tweet->id;
                $tweetPreview = Twitter::getOembed(['url' => $url, 'hide_media' => true, 'maxwidth' => 550]);

                $authorPosts[] = $tweetPreview->html;
                $i++;
            }

            return $authorPosts;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }

    /**
     * get similar posts of a post
     *
     * @param NewsCase $case
     * @return array
     */
    public function getSimilarPosts($case){
        try{
            $tweets = Twitter::getSearch(['q' => $case->title, 'count' => 20,  'max_id' => $case->tweet_id]);

            $similarPosts = [];

            $i = 0;
            foreach ($tweets->statuses as $key => $tweet) {

                if($i == 5)
                    continue;

                $url = 'https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id;
                $tweetPreview = Twitter::getOembed(['url' => $url, 'hide_media' => true, 'maxwidth' => 550]);

                $similarPosts[] = $tweetPreview->html;
                $i++;
            }

            return $similarPosts;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }

    /**
     * get same area posts
     *
     * @param NewsCase $case
     * @return array
     */
    public function getSameAreaPosts($case){
        try{
            $place = Twitter::getGeoSearch(['query' => $case->location]);
            $tweets = Twitter::getSearch(['q' => 'place:'.$place->result->places[0]->id, 'count' => 20, 'max_id' => $case->tweet_id]);

            $similarPosts = [];
            $i = 0;
            foreach ($tweets->statuses as $key => $tweet) {

                if($i == 5)
                    continue;

                $url = 'https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id;
                $tweetPreview = Twitter::getOembed(['url' => $url, 'hide_media' => true, 'maxwidth' => 550]);

                $similarPosts[] = $tweetPreview->html;
                $i++;
            }

            return $similarPosts;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }

}
