@extends('layouts.app')
@section('title', 'Same Area Posts')
@section('page-header', 'Same Area Posts')
@section('content')
    <div class="inner-info-content">
        @if(!empty($sameAreaPosts))
            @foreach($sameAreaPosts as $tweetPreview)
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
