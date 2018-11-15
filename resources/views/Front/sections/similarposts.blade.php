@extends('layouts.app')
@section('title', 'Similar Posts')
@section('page-header', 'Similar Posts')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id) }}" class="btn btn-success">Refresh</a>
@endsection
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
