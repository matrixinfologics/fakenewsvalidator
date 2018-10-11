@extends('layouts.app')
@section('title', 'Post Analysis')
@section('page-header', 'Post Analysis')
@section('content')
    <div class="inner-info-content">
         <h3>{{ $case->title }}</h3>
        <ul>
            <li><a href="{{ $case->url }}">URL: {{ $case->url }}</li>
            <li>Keywords: {{ $case->keywords }}</a></li>
            <li>Reported By: {{ isset($case->user)? $case->user->name: '' }}</li>
            <li>Reported on: {{ $case->created_at->format('d/m/Y h:i') }}</li>
            <li>Location: {{ $case->location }}</li>
        </ul>
        <a href="{{ route('editcase', $case->id) }}" class="btn btn-info" role="button">EDIT</a>
    </div>
    <h3 class="info-head">PREVIEW</h3>
    <div class="inner-info-content">
        {!!html_entity_decode($tweetPreview)!!}
    </div>
@endsection
