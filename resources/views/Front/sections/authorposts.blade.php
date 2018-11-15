@extends('layouts.app')
@section('title', 'Author Latest Posts')
@section('page-header', 'Author Latest Posts')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id.$duration) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
    <div class="inner-info-content">
        {{ Form::open(['url'=> route('author-posts', $case->id), 'method' => 'GET', 'id' => 'post_duration_form']) }}
            {{ Form::label('duration', 'Filter By: ') }}
            {{ Form::select('duration',
                array('24' => 'Last 24 Hours', 'week' => 'Last Week', 'month' => "Last Month"),
                isset($duration)? $duration: null,
                ['class' => 'form-control author_post_duration'])
            }}
        {{ Form::close() }}

        @if(!empty($authorPosts))
            @foreach($authorPosts as $tweetPreview)
                {!!html_entity_decode($tweetPreview)!!}
            @endforeach
        @else
            <p> No item Found </p>
        @endif
    </div>
    @include('layouts.app-partials.flag-buttons')
@endsection
