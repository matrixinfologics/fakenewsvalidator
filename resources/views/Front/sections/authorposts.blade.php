@extends('layouts.app')
@section('title', 'Author Latest Posts')
@section('page-header', 'Author Latest Posts')
@section('content')
    <div class="inner-info-content">
        @foreach($authorPosts as $tweetPreview)
            {!!html_entity_decode($tweetPreview)!!}
        @endforeach
    </div>
     <div class="inner-info-content">
        {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>
@endsection
