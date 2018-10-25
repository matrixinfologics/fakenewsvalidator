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
    @include('layouts.app-partials.flag-buttons')
@endsection
