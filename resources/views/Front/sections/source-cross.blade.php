@extends('layouts.app')
@section('title', 'Source Cross Checking')
@section('page-header', 'Source Cross Checking')
@section('content')
    <div class="inner-info-content">
        @if($fakeCount > 0)
            <h5>This source is flagged {{ $fakeCount }} time(s) as fake news in our database</h5>
        @else
            <h5>This source is not flagged as fake news in our database</h5>
        @endif
    </div>
    @include('layouts.app-partials.flag-buttons')
@endsection
