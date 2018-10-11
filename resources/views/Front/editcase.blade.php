@extends('layouts.app')
@section('title', 'Edit Case')
@section('page-header', 'Edit Case')
@section('content')
    <div class="inner-info-content main-login">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                  <div class="form-main">
                    <h1>Edit Case</h1>
                     {{ Form::model($case, ['url'=> route('editcase', $case->id)]) }}
                        <div class="form-group {{ $errors->first('title')?'has-error':'' }}">
                            {{ Form::text('title', null, ['class' => 'form-control', 'placeholder' => 'Title']) }}
                            <span class="help-block">{{ $errors->first('title') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('keywords')?'has-error':'' }}">
                            {{ Form::text('keywords', null, ['class' => 'form-control', 'placeholder' => 'Keywords']) }}
                            <span class="help-block">{{ $errors->first('keywords') }}</span>
                        </div>
                        {{ Form::submit('Update', ['class' => 'btn btn-primary']) }}
                     {{ Form::close() }}
                  </div>
                </div>
            </div>
        </div>
    </div>
@endsection
