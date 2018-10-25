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
    @include('layouts.app-partials.flag-buttons')
@endsection
