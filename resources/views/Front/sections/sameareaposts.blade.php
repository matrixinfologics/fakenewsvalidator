@extends('layouts.app')
@section('title', 'Same Area Posts')
@section('page-header', 'Same Area Posts')
@section('content')
    <div class="inner-info-content">
        @foreach($sameAreaPosts as $tweetPreview)
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
