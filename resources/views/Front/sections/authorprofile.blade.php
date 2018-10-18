@extends('layouts.app')
@section('title', 'Author Profile')
@section('page-header', 'Author Profile')
@section('content')
    <div class="inner-info-content">
        <div id="tweet_history_chart"></div>
    </div>
    <div class="inner-info-content">
        {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>
  <script>
    $(function(){
      let inst = new EnableHighCharts();
      inst.showTweetHistoryChart(); // console "here"
    })
  </script>
@endsection
