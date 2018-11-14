@extends('layouts.app')
@section('title', 'Author Latest Posts')
@section('page-header', 'Author Latest Posts')
@section('refresh-button')
    <a href="{{ route('cache', [$case, $sectionId]) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
    <div class="inner-info-content">
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
