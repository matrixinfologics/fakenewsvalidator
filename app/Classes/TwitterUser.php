<?php

namespace App\Classes;


use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterUser
{

    public $consumer_key;
    public $consumer_secret;
    public $oauth_token;
    public $oauth_secret;
    public $connection;
    public $user;
    public $connected_user;
    public $max_friends_count;
    public $max_followers_count;
    public $max_tweets;

    public function __construct($consumer_key, $consumer_secret, $oauth_token, $oauth_secret, $user_screen_name)
    {
        date_default_timezone_set("GMT");
        $this->consumer_key = $consumer_key;
        $this->consumer_secret = $consumer_secret;
        $this->oauth_token = $oauth_token;
        $this->oauth_secret = $oauth_secret;
        $this->connection = new TwitterOAuth($this->consumer_key, $this->consumer_secret, $this->oauth_token, $this->oauth_secret);
        $this->connected_user = $this->connection->get("account/verify_credentials");
        $this->user = $this->getUserInfo($user_screen_name);
        $this->max_followers_count = 500;
        $this->max_friends_count = 500;
        $this->max_tweets = 500;
    }

    public function getUserInfo($screen_name)
    {
        //USER_INFO REQUEST
        $api_params = array(
            'screen_name' => $screen_name,
        );
        $user_info = $this->connection->get("users/show", $api_params);

        return $user_info;
    }

    public function getUserTweets($screen_name)
    {
        //USER_TWEETS REQUEST
        $api_params = array(
            'screen_name'     => $screen_name,
            'count'           => 200,
            'include_rts'     => 1,
            'exclude_replies' => 0,
        );

        $all_timeline = array();
        while (true) {
            $user_timeline = $this->connection->get("statuses/user_timeline", $api_params);
            if (count($user_timeline)) {
                $all_timeline = array_merge($all_timeline, $user_timeline);
                $last_tweet = end($user_timeline);
                $api_params['max_id'] = bcsub($last_tweet->id, 1);
            } else {
                break;
            }

            if (count($all_timeline) > $this->max_tweets) {
                break;
            }
        }

        return $all_timeline;
    }

    public function getFollowers($screen_name)
    {
        $all_followers = array();
        $api_params = array(
            'screen_name' => $screen_name,
            'cursor'      => -1,
        );

        do {
            $followers_ids = $this->connection->get("followers/ids", $api_params);
            if (is_array($followers_ids->ids) && !empty($followers_ids->ids)) {
                $all_followers = array_merge($all_followers, $followers_ids->ids);
            }

            if (count($all_followers) > $this->max_followers_count) {
                break;
            }

            if (isset($followers_ids->next_cursor)) {
                $api_params['cursor'] = $followers_ids->next_cursor;
            }

        } while (isset($followers_ids->next_cursor) && $followers_ids->next_cursor > 0);

        $all_followers_data = array();
        $follower_ids = "";
        for ($i = 0; ($i < count($all_followers) && $i <= $this->max_followers_count); $i++) {
            $follower_ids = $follower_ids . $all_followers[$i];
            if ($i > 0 && $i % 100 == 0) {
                $followers_data = $this->usersLookup($follower_ids);
                if (is_array($followers_data) && !empty($followers_data)) {
                    $all_followers_data = array_merge($all_followers_data, $followers_data);
                }
                $follower_ids = "";
            } else {
                $follower_ids .= ",";
            }
        }

        $followers_data = $this->usersLookup($follower_ids);

        if (is_array($followers_data) && !empty($followers_data)) {
            $all_followers_data = array_merge($all_followers_data, $followers_data);
        }

        $indexed_data = array();
        foreach ($all_followers_data as $follower_data) {
            $indexed_data[$follower_data->screen_name] = $follower_data;
        }

        return $indexed_data;
    }

    public function getFriends($screen_name)
    {
        $all_friends = array();
        $api_params = array(
            'screen_name' => $screen_name,
            'cursor'      => -1,
        );

        do {
            $friends_ids = $this->connection->get("friends/ids", $api_params);
            if (is_array($friends_ids->ids) && !empty($friends_ids->ids)) {
                $all_friends = array_merge($all_friends, $friends_ids->ids);
            }

            if (count($all_friends) > $this->max_followers_count) {
                break;
            }

            if (isset($friends_ids->next_cursor)) {
                $api_params['cursor'] = $friends_ids->next_cursor;
            }

        } while (isset($friends_ids->next_cursor) && $friends_ids->next_cursor > 0);

        $all_friends_data = array();
        $friend_ids = "";
        for ($i = 0; ($i < count($all_friends) && $i <= $this->max_friends_count); $i++) {
            $friend_ids = $friend_ids . $all_friends[$i];
            if ($i > 0 && $i % 100 == 0) {
                $friends_data = $this->usersLookup($friend_ids);
                if (is_array($friends_data) && !empty($friends_data)) {
                    $all_friends_data = array_merge($all_friends_data, $friends_data);
                }

                $friend_ids = "";
            } else {
                $friend_ids .= ",";
            }
        }

        $friends_data = $this->usersLookup($friend_ids);
        if (is_array($friends_data) && !empty($friends_data)) {
            $all_friends_data = array_merge($all_friends_data, $friends_data);
        }

        $indexed_data = array();
        foreach ($all_friends_data as $friend_data) {
            $indexed_data[$friend_data->screen_name] = $friend_data;
        }

        return $indexed_data;
    }

    public function get_all_users_in_timeline($arr_screen_names)
    {
        $all_friends_data = array();
        $screen_names = "";
        for ($i = 0; $i < count($arr_screen_names); $i++) {
            $screen_names = $screen_names . $arr_screen_names[$i];
            if ($i > 0 && $i % 100 == 0) {
                $all_friends_data = array_merge($all_friends_data, $this->usersLookupName($screen_names));
                $screen_names = "";
            } else {
                $screen_names .= ",";
            }
        }

        if(is_array($this->usersLookupName($screen_names))) {
            $all_friends_data = array_merge($all_friends_data, $this->usersLookupName($screen_names));
        }
        $indexed_data = array();
        foreach ($all_friends_data as $friend_data) {
            $indexed_data[$friend_data->screen_name] = $friend_data;
        }

        return $indexed_data;
    }

    public function usersLookup($user_id)
    {
        $all_users = array();
        $api_params = array(
            'user_id' => $user_id,
        );

        $users = $this->connection->get("users/lookup", $api_params);

        return $users;
    }

    public function usersLookupName($screen_name)
    {
        $all_users = array();
        $api_params = array(
            'screen_name' => $screen_name,
        );

        $users = $this->connection->get("users/lookup", $api_params);

        return $users;

    }

    public function getUserStatistics()
    {

        $tmp_users_in_timeline           = array();
        $user_stats                      = new \stdClass();
        $user_stats->user                = $this->getUserInfo($this->user->screen_name);
        $user_stats->followers           = $this->getFollowers($this->user->screen_name);
        $user_stats->friends             = $this->getFriends($this->user->screen_name);
        $user_stats->statuses_count      = $user_stats->user->statuses_count;
        $user_stats->total_tweets        = 0;
        $user_stats->total_links         = 0;
        $user_stats->total_replies       = 0;
        $user_stats->total_user_mentions = 0;
        $user_stats->total_retweets      = 0;
        $user_stats->total_hashtags      = 0;
        $user_stats->most_retweeted      = [];
        $user_stats->most_favorited      = [];
        $user_stats->hashtags            = [];
        $user_stats->symbols             = [];
        $user_stats->user_mentions       = [];
        $user_stats->most_retweeted_users= [];
        $user_stats->most_replied_to_users = [];

        $all_timeline = $this->getUserTweets($this->user->screen_name);
        foreach ($all_timeline as $tweet) {
            $user_stats->tweets[$tweet->id_str] = $tweet;
            $user_stats->total_tweets++;
            $tweet_datetime = strtotime($tweet->created_at);
            $tweet_weekday = (int) date("w", $tweet_datetime);
            $tweet_hour = (string) date("H", $tweet_datetime);
            $tweet_Ymd = (string) date("Y-m-d", $tweet_datetime);
            if (!isset($user_stats->tweets_on_weekdays[$tweet_weekday])) {
                $user_stats->tweets_on_weekdays[$tweet_weekday] = 1;
            } else {
                $user_stats->tweets_on_weekdays[$tweet_weekday]++;
            }

            if (!isset($user_stats->tweets_on_hours[$tweet_hour])) {
                $user_stats->tweets_on_hours[$tweet_hour] = 1;
            } else {
                $user_stats->tweets_on_hours[$tweet_hour]++;
            }

            if (!isset($user_stats->tweets_on_days[$tweet_Ymd])) {
                $user_stats->tweets_on_days[$tweet_Ymd] = 1;
            } else {
                $user_stats->tweets_on_days[$tweet_Ymd]++;
            }

            //This is a retweet
            $not_retweet = true;
            $original_tweet = null;
            if (isset($tweet->retweeted_status)) {
                $not_retweet = false;
                $user_stats->total_retweets++;
                $original_tweet = $tweet->retweeted_status;
                $tmp_users_in_timeline[] = $original_tweet->user->screen_name;

                if (!isset($user_stats->most_retweeted_users[$original_tweet->user->screen_name])) {
                    $user_stats->most_retweeted_users[$original_tweet->user->screen_name] = 1;
                } else {
                    $user_stats->most_retweeted_users[$original_tweet->user->screen_name]++;
                }
            }

            //This is a reply
            if (isset($tweet->in_reply_to_status_id_str) || isset($tweet->in_reply_to_screen_name)) {
                $user_stats->total_replies++;
                if (isset($tweet->in_reply_to_screen_name)) {
                    $tmp_users_in_timeline[] = $tweet->in_reply_to_screen_name;
                }

                if (!isset($user_stats->most_replied_to_users[$tweet->in_reply_to_screen_name])) {
                    $user_stats->most_replied_to_users[$tweet->in_reply_to_screen_name] = 1;
                } else {
                    $user_stats->most_replied_to_users[$tweet->in_reply_to_screen_name]++;
                }
            }

            $hashtags = $tweet->entities->hashtags;

            if (count($hashtags) > 0 && $not_retweet) {
                foreach ($hashtags as $hashtag) {
                    if (!isset($user_stats->hashtags[$hashtag->text])) {
                        $user_stats->hashtags[$hashtag->text] = 1;
                    } else {
                        $user_stats->hashtags[$hashtag->text]++;
                    }

                    $user_stats->total_hashtags += 1;
                }
            }

            $symbols = $tweet->entities->symbols;

            if (count($symbols) > 0 && $not_retweet) {
                foreach ($symbols as $symbol) {
                    if (!isset($user_stats->symbols[$symbol->text])) {
                        $user_stats->symbols[$symbol->text] = 1;
                    } else {
                        $user_stats->symbols[$symbol->text]++;
                    }

                    $user_stats->total_symbols++;
                }
            }

            $user_mentions = $tweet->entities->user_mentions;

            if (count($user_mentions) > 0 && $not_retweet) {
                foreach ($user_mentions as $user_mention) {
                    $tmp_users_in_timeline[] = $user_mention->screen_name;
                    if (!isset($user_stats->user_mentions[$user_mention->screen_name])) {
                        $user_stats->user_mentions[$user_mention->screen_name] = 1;
                    } else {
                        $user_stats->user_mentions[$user_mention->screen_name]++;
                    }

                    $user_stats->total_user_mentions++;
                }
            }

            $urls = $tweet->entities->urls;
            if ($not_retweet) {
                $user_stats->total_links += count($urls);
            }

            if ($not_retweet && $tweet->retweet_count > 0) {
                $user_stats->most_retweeted[$tweet->id_str] = $tweet->retweet_count;
            }

            if ($not_retweet && $tweet->favorite_count > 0) {
                $user_stats->most_favorited[$tweet->id_str] = $tweet->favorite_count;
            }

        }

        $last_tweet = end($all_timeline);
        $user_stats->total_days_since_first_tweet = (int) ((strtotime("now") - strtotime($last_tweet->created_at)) / (60 * 60 * 24));
        $user_stats->first_tweet_time = strtotime($last_tweet->created_at);
        $user_stats->average_tweets_per_day = round($user_stats->total_tweets / $user_stats->total_days_since_first_tweet, 2);
        $user_stats->users_in_timeline = $this->get_all_users_in_timeline($tmp_users_in_timeline);
        ksort($user_stats->tweets_on_hours);
        ksort($user_stats->tweets_on_days);
        ksort($user_stats->tweets_on_weekdays);
        arsort($user_stats->hashtags);
        arsort($user_stats->symbols);
        arsort($user_stats->user_mentions);
        arsort($user_stats->most_retweeted_users);
        arsort($user_stats->most_replied_to_users);
        arsort($user_stats->most_retweeted);
        arsort($user_stats->most_favorited);

        return $user_stats;
    }

}
