@extends('layouts.app', ['withoutSidebar' => true])
@section('title', 'New Case')
@section('page-header', 'New Case')
@section('content')
    <div class="inner-info-content main-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="form-main">
                    <h1>New Case</h1>
                     {{ Form::open(['url'=> route('newcase')]) }}
                        <div class="form-group {{ $errors->first('title')?'has-error':'' }}">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) }}
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('url')?'has-error':'' }}">
                            {{ Form::text('url', null, ['class' => 'form-control', 'placeholder' => 'URL']) }}
                            <span class="help-block">{{ $errors->first('url') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('keywords')?'has-error':'' }}">
                            {{ Form::text('keywords', null, ['class' => 'form-control', 'placeholder' => 'Keywords']) }}
                            <span class="help-block">{{ $errors->first('keywords') }}</span>
                        </div>
                        {{ Form::submit('Next', ['class' => 'btn btn-primary']) }}
                     {{ Form::close() }}
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
