@extends('layouts.app')
@section('title', 'Post Geo Location')
@section('page-header', 'Post Geo Location')
@section('content')
    <div class="inner-info-content">
        <div style="width: 100%; height: 500px;">
            {!! Mapper::render() !!}
        </div>
    </div>
    <div class="inner-info-content">
        {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>

@endsection
