@extends('layouts.app')
@section('title', 'Discussions')
@section('page-header', 'Discussions')
@section('content')
     <div class="inner-info-content image_search">
        <div class="discussions">
            @if(sizeof($discussions) > 0)
                @foreach($discussions as $discussion)
                    <div class="discuss_main{{ Auth::id() == $discussion->user->id ? ' my-msg':'' }}">

                        <div class="message_main">
                            <p>{{ $discussion->message }}</p>
                        </div>
                        <p class="message_detail"><strong>By</strong> <i>{{ $discussion->user->name }}</i> <strong>On </strong> <i>{{ $discussion->created_at->format('d/m/Y h:i') }} </i> </p>
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
