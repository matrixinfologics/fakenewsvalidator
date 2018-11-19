@extends('layouts.app')
@section('title', 'Author Profile')
@section('page-header', 'Author Profile')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')

@php
if ( !empty( $stats->user->name ) ) {
    $username = $stats->user->name;
} else {
    $username = "Twitter User";
}

// History Chart
$tweetHistoryData = [];
$startTime = $stats->first_tweet_time;
$endTime = time();
for ( $i = $startTime; $i <= $endTime; $i = $i + 86400 ) {
    $loop_date = date( 'Y-m-d', $i ); // 2010-05-01, 2010-05-02, etc
    if(isset($stats->tweets_on_days[$loop_date])){
        $tweetHistoryData[] = $stats->tweets_on_days[$loop_date];
    }else{
        $tweetHistoryData[] = 0;
    }
}
$pointStart = date("Y",$stats->first_tweet_time).", ".(date("m",$stats->first_tweet_time)-1).", ".date("d",$stats->first_tweet_time);

// Most Retweet Chart
$mostRetweets = [];
foreach($stats->most_retweeted_users as $key => $value) {
   $mostRetweets[] =  ['@'.$key, $value];
}

// Most Replied Chart
$mostReplied = [];
foreach($stats->most_replied_to_users as $key => $value) {
   $mostReplied[] =  ['@'.$key, $value];
}

// Most Mentioned Chart
$mostMentioned = [];
foreach($stats->user_mentions as $key => $value) {
   $mostMentioned[] =  ['@'.$key, $value];
}

// HashTags Chart
$hashTags = [];
foreach($stats->hashtags as $key => $value) {
   $hashTags[] =  ['@'.$key, $value];
}

// Days of Week Chart
$daysOfWeek = [];
for($i = 0; $i < 7; $i++){
    if(isset($stats->tweets_on_weekdays[$i])){
        $daysOfWeek[] = $stats->tweets_on_weekdays[$i];
    }else{
        $daysOfWeek[] = 0;
    }
}

// Hours of Day Chart
$hoursOfDay = [];
for($i = 0; $i < 24; $i++){
    $ind = $i < 10 ? "0".$i : $i;
    if(isset($stats->tweets_on_hours[$ind])){
        $hoursOfDay[] = $stats->tweets_on_hours[$ind];
    }else{
        $hoursOfDay[] = 0;
    }
}
@endphp
    <div class="inner-info-content">
        <div class="container">
            <div class="inner-info-content">
                <div class="user-statistics">
                    <img class="twitter-user-statistics" src="{{ asset('img/twitter-icon.png') }}"> Twitter User Statistics
                </div>
                <div class="user-profile-main">
                    <img class="user-prof" src="{{ !empty( $stats->user->profile_image_url )? $stats->user->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><p> {{ $username }}</p>
                    <ul>
                        <li>{{ $stats->statuses_count }} Tweets</li>
                        <li>{{ $stats->user->friends_count }} Following</li>
                        <li>{{ $stats->user->followers_count }} Followers</li>
                    </ul>
                </div>
            </div>

            <!--Preview---->
            <h3 class="info-head">TWEET ANALYTICS</h3>
            <div class="inner-info-content analytics">
                <div class="row">
                    <div class="col-md-4">
                        <ul class="main-list-ul">
                        <li class="main-analytics"><span>{{ $stats->total_tweets }}</span> Tweets Since {{ date("d.m.Y",$stats->first_tweet_time) }}</li>
                        <li><span>{{ round($stats->average_tweets_per_day) }}</span>  Tweets Per Day</li>
                        <li><span>{{ $stats->total_retweets }}</span>  Retweets</li>
                        <li><span>{{ $stats->total_user_mentions }}</span>  User Mentions</li>
                        <li><span>{{ $stats->total_replies }}</span>  Replies</li>
                        <li><span>{{ $stats->total_links }}</span>  Links</li>
                        <li><span>{{ $stats->total_hashtags }}</span>  Hashtags</li>
                        <li><span>{{ count($stats->most_retweeted) }}</span>  Tweets Retweeted</li>
                        <li><span>{{ count($stats->most_favorited) }}</span>  Tweets Favorited</li>
                        </ul>
                    </div>
                    <div class="col-md-8">
                        <div id="tweet_history_chart" style="width:100%; min-width: 310px; height: 400px; margin: 0 auto;"></div>
                    </div>
                </div>
            </div>

            <!-- 3rd-post--->
            @if(!empty($stats->most_retweeted_users))
                <h3 class="info-head">USER MOST RETWEETED</h3>
                <div class="inner-info-content analytics">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="main-list-ul most-reply">
                                @foreach($stats->most_retweeted_users as $user => $count)
                                    <li><div class="over_content_custom"><img src="{{ $stats->users_in_timeline[$user]->profile_image_url }}"><span> @ {{ $user }}</span> </div> <div class="over_content_mention"><span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div id="users_most_retweeted_chart" style="width:100%; min-width: 310px; height: 400px; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 4th-post--->
            @if(!empty($stats->most_replied_to_users))
                <h3 class="info-head">USER MOST REPLIED TO</h3>
                <div class="inner-info-content analytics">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="main-list-ul most-reply">
                                @foreach($stats->most_replied_to_users as $user => $count)
                                    <li><div class="over_content_custom"><img src="{{ !empty( $stats->users_in_timeline[$user])? $stats->users_in_timeline[$user]->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><span> @ {{ $user }}</span></div> <div class="over_content_mention"><span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div id="users_most_replied_to_chart" style="width:100%; min-width: 310px; height: 400px; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>
            @endif

            <!-- 5th-post-->
            @if(!empty($stats->user_mentions))
                <h3 class="info-head">USER MOST MENTIONED</h3>
                <div class="inner-info-content analytics">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="main-list-ul most-reply">
                                @foreach($stats->user_mentions as $user => $count)
                                    <li><div class="over_content_custom"><img src="{{ !empty( $stats->users_in_timeline[$user])? $stats->users_in_timeline[$user]->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><span> @ {{ $user }}</span> </div> <div class="over_content_mention"><span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div id="users_most_mentioned_chart" style="width:100%; min-width: 310px; height: 400px; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>
            @endif

            <!--6th Post-->
            @if(!empty($stats->hashtags))
                <h3 class="info-head">HASHTAG MOST USED</h3>
                <div class="inner-info-content analytics">
                    <div class="row">
                        <div class="col-md-4">
                            <ul class="main-list-ul most-reply most-hashtag">
                                @foreach($stats->hashtags as $user => $count)
                                    <li><img src="{{ !empty( $stats->users_in_timeline[$user])? $stats->users_in_timeline[$user]->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><div class="over_content_custom"><span> @ {{ $user }}</span> </div> <div class="over_content_mention"><span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-8">
                            <div id="hashtags_chart" style="width:100%; min-width: 310px; height: 400px; margin: 0 auto;"></div>
                        </div>
                    </div>
                </div>
            @endif

            <!--6th Post-->
            <div class="inner-info-content analytics">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="info-head">TWEETS MOST RETWEETED</h3>
                        <ul class="main-list-ul most-reply most-hashtag">
                            @if(!empty($stats->most_retweeted))
                                @foreach($stats->most_retweeted as $user => $count)
                                    <li><div class="over_content_custom"><img src="{{ !empty( $stats->users_in_timeline[$user])? $stats->users_in_timeline[$user]->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><span> @ {{ $user }}</span></div> <div class="over_content_mention"> <span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            @else
                                 <li>No record found</li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3 class="info-head">TWEETS MOST FAVORITED</h3>
                        <ul class="main-list-ul most-reply most-hashtag">
                            @if(!empty($stats->most_retweeted))
                                @foreach($stats->most_favorited as $user => $count)
                                    <li><div class="over_content_custom"><img src="{{ !empty( $stats->users_in_timeline[$user])? $stats->users_in_timeline[$user]->profile_image_url : 'http://abs.twimg.com/sticky/default_profile_images/default_profile_normal.png' }}"><span> @ {{ $user }}</span> </div> <div class="over_content_mention"> <span class="mention">{{ $count }}</span></div></li>
                                @endforeach
                            @else
                                 <li>No record found</li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>

            <!--6th Post-->
            <div class="inner-info-content analytics">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="info-head">DAYS OF WEEK</h3>
                        <div id="days_of_week_chart" style="width:100%; min-width: 310px; height: 500px; margin: 0 auto;"></div>
                    </div>
                    <div class="col-md-6">
                        <h3 class="info-head">HOURS OF DAY</h3>
                        <div id="hours_of_day_chart" style="width:100%; min-width: 310px; height: 500px; margin: 0 auto;"></div>
                    </div>
                </div>
            </div>

            <div class="bottom-button">
               @include('layouts.app-partials.flag-buttons')
            </div>
        </div>
    </div>

  <script>
    $(function(){
      let inst = new EnableHighCharts();
      inst.showTweetHistoryChart(<?php echo json_encode($tweetHistoryData); ?>, Date.UTC(<?php echo $pointStart; ?>));
      inst.showMostStatsChart('users_most_retweeted_chart', 'Users most retweeted', <?php echo json_encode($mostRetweets); ?>);
      inst.showMostStatsChart('users_most_replied_to_chart', 'Users most replied to', <?php echo json_encode($mostReplied); ?>);
      inst.showMostStatsChart('users_most_mentioned_chart', 'Users most mentioned to', <?php echo json_encode($mostMentioned); ?>);
      inst.showMostStatsChart('hashtags_chart', 'Hashtags', <?php echo json_encode($hashTags); ?>);
      inst.showDaysofWeekColumnChart(<?php echo json_encode($daysOfWeek); ?>);
      inst.showHoursOfDayColumnChart(<?php echo json_encode($hoursOfDay); ?>);
    })
  </script>
@endsection
