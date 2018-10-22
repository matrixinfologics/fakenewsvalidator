@extends('layouts.app')
@section('title', 'Similar Posts')
@section('page-header', 'Similar Posts')
@section('content')
    <div class="inner-info-content">
        @if(!empty($similarPosts))
            @foreach($similarPosts as $tweetPreview)
                {!!html_entity_decode($tweetPreview)!!}
            @endforeach
        @else
            <p> No item Found </p>
        @endif
    </div>
     <div class="inner-info-content flag_button">
        {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>
@endsection
