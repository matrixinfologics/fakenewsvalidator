<?php

namespace App\Classes;

use Illuminate\Database\Eloquent\Model;
use App\Company;
use App\NewsCase;
use Auth;
use Thujohn\Twitter\Twitter as twitterConfig;
use Twitter;
use Mapper;
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
            return Twitter::getTweet($tweetId, ['include_entities' => true, 'tweet_mode' => 'extended']);
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
            $tweet = Twitter::getOembed(['url' => $tweetUrl, 'hide_media' => false]);
            return $tweet->html;
        } catch (RunTimeException $e) {
            throw new \Exception("Please provide correct detail!");
        }
    }

    /**
     * get latest posts of author
     *
     * @param string $author
     * @param string $duration
     * @return array
     */
    public function getAuthorPosts($author, $duration){
        try{
            $tweets = Twitter::getUserTimeline(['screen_name' => $author, 'count' => 100, 'exclude_replies'=> true, 'include_rts' => false]);
            $tweets = $this->filterContentByDuration($tweets, $duration);


            $authorPosts = [];
            foreach ($tweets as $tweet) {
                $tweetPreview = Twitter::getOembed(['url' => $tweet['url'], 'hide_media' => true, 'maxwidth' => 550]);
                $authorPosts[] = $tweetPreview->html;
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
            $tweets = Twitter::getSearch(['q' => $case->keywords, 'count' => 20]);
            $tweets = $this->filterContent($tweets->statuses);

            $similarPosts = [];

            foreach ($tweets as $tweet) {
                $tweetPreview = Twitter::getOembed(['url' =>$tweet['url'], 'hide_media' => true, 'maxwidth' => 550]);
                $similarPosts[] = $tweetPreview->html;
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

            if(empty($place->result->places)) {
                $geo = Mapper::location($case->location);
                $location = $geo->getAddress();
                $place = Twitter::getGeoSearch(['query' => $location]);
            }

            $tweets = Twitter::getSearch(['q' => 'place:'.$place->result->places[0]->id, 'count' => 20]);
            $tweets = $this->filterContent($tweets->statuses);

            $similarPosts = [];
            foreach ($tweets as $tweet) {
                $tweetPreview = Twitter::getOembed(['url' => $tweet['url'], 'hide_media' => true, 'maxwidth' => 550]);
                $similarPosts[] = $tweetPreview->html;
            }

            return $similarPosts;
        } catch (RunTimeException $e) {
            throw new \Exception($e->getMessage());
        }
    }


    public function getGeo($place){
        $place = Twitter::getGeo($place);

        $coordinates['latitude'] = $place->contained_within[0]->centroid[1];
        $coordinates['longitude'] = $place->contained_within[0]->centroid[0];

        return $coordinates;
    }

    public function filterContent($data) {
        $filterData = [];
        $i = 0;
        foreach ($data as $key => $tweet) {
            if(!$this->in_array_r($tweet->id, $filterData) && strpos($tweet->text, 'RT') !== 0) {
                if($i == 5)
                    continue;

                $filterData[$i]['tweet_id'] = $tweet->id;
                $filterData[$i]['author'] = $tweet->user->screen_name;
                $filterData[$i]['posted_date'] = $tweet->created_at;
                $filterData[$i]['url'] = 'https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id;
                $i++;
            }
        }

        return $filterData;
    }

    public function filterContentByDuration($data, $duration) {
        $filterData = [];
        $i = 0;
        foreach ($data as $key => $tweet) {
                $filterData[$i]['tweet_id'] = $tweet->id;
                $filterData[$i]['author'] = $tweet->user->screen_name;
                $filterData[$i]['posted_date'] = $tweet->created_at;
                $filterData[$i]['url'] = 'https://twitter.com/'.$tweet->user->screen_name.'/status/'.$tweet->id;
                $i++;
        }
        if($duration == '24')
            $rangeStart = strtotime('-24 Hours');
        else if($duration == 'week')
            $rangeStart = strtotime('-1 week');
        else
            $rangeStart = strtotime('-1 month');

        $rangeEnd = strtotime('now');

        $filterData = array_filter($filterData, function($var) use ($rangeStart, $rangeEnd) {
            $utime = strtotime($var['posted_date']);
            return $utime <= $rangeEnd && $utime >= $rangeStart;
         });

        return $filterData;
    }

    public function in_array_r($needle, $haystack, $strict = false) {
        foreach ($haystack as $item) {
            if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && $this->in_array_r($needle, $item, $strict))) {
                return true;
            }
        }

        return false;
    }
}
