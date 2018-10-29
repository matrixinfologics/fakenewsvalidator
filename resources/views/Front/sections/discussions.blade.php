@extends('layouts.app')
@section('title', 'Discussions')
@section('page-header', 'Discussions')
@section('content')
     <div class="inner-info-content image_search">
        <div class="discussions">
            @if(sizeof($discussions) > 0)
                @foreach($discussions as $discussion)
                    <div class="row">
                        <div class="col-md-2">
                            <strong>{{ $discussion->user->name }}</strong>
                            <p>{{ $discussion->created_at->format('d/m/Y h:i') }}</p>
                        </div>
                        <div class="col-md-10">
                            <p>{{ $discussion->message }}</p>
                        </div>
                    </div>
                @endforeach
            @else
                <p>Start Discussion</p>
            @endif

        </div>
        <div class="discussions_form">
            {{ Form::open(['url'=> route('discussions', $case->id)]) }}
                <div class="form-group {{ $errors->first('message')?'has-error':'' }}">
                    {{ Form::textarea('message', null, ['class' => 'form-control', 'placeholder' => 'Message', 'rows' => 4]) }}
                    <span class="help-block">{{ $errors->first('message') }}</span>
                </div>
                {{ Form::button('Submit', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) }}
            {{ Form::close() }}
        </div>
    </div>
    @include('layouts.app-partials.flag-buttons')
@endsection
