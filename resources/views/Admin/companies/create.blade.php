@extends('layouts.admin')

@section('title', 'Add Company')
@section('page-header', 'Add Company')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Company Info</h3>
                    <a href="{{ route('companies.index') }}" title="Back" class="btn btn-sm btn-primary pull-right">
                        <i class="glyphicon glyphicon-fast-backward"></i>
                         Back
                    </a>
                </div>
                {{ Form::open(['url'=> route('companies.store')]) }}
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('name')?'has-error':'' }}">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('website')?'has-error':'' }}">
                            {{ Form::text('website', '', ['class' => 'form-control', 'placeholder' => 'Website']) }}
                            <span class="help-block">{{ $errors->first('website') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('phone')?'has-error':'' }}">
                            {{ Form::text('phone', '', ['class' => 'form-control', 'placeholder' => 'Phone']) }}
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('address')?'has-error':'' }}">
                            {{ Form::text('address', '', ['class' => 'form-control', 'placeholder' => 'Address']) }}
                            <span class="help-block">{{ $errors->first('address') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('admin')?'has-error':'' }}">
                            {{ Form::select('admin', $users, null, ['class' => 'form-control select2', 'placeholder' => 'Choose company admin']) }}
                            <span class="help-block">{{ $errors->first('admin') }}</span>
                        </div>
                        <div class="form-group has-warning">
                               <span class="help-block"><i class="glyphicon glyphicon-question-sign"></i> If company admin is not available please <a href="{{ route('users.create')}}" title="Create User"> create new user</a></span>
                        </div>
                        <div class="box-header with-border">
                            <h3 class="box-title">Twitter API Details</h3>
                        </div>
                        <div class="form-group {{ $errors->first('twitter_consumer_key')?'has-error':'' }}">
                            {{ Form::text('twitter_consumer_key', '', ['class' => 'form-control', 'placeholder' => 'Twitter Consumer Key']) }}
                            <span class="help-block">{{ $errors->first('twitter_consumer_key') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('twitter_consumer_secret')?'has-error':'' }}">
                            {{ Form::text('twitter_consumer_secret', '', ['class' => 'form-control', 'placeholder' => 'Twitter Consumer Secret']) }}
                            <span class="help-block">{{ $errors->first('twitter_consumer_secret') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('twitter_access_token')?'has-error':'' }}">
                            {{ Form::text('twitter_access_token', '', ['class' => 'form-control', 'placeholder' => 'Twitter Access Token']) }}
                            <span class="help-block">{{ $errors->first('twitter_access_token') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('twitter_access_token_secret')?'has-error':'' }}">
                            {{ Form::text('twitter_access_token_secret', '', ['class' => 'form-control', 'placeholder' => 'Twitter Access Token Secret']) }}
                            <span class="help-block">{{ $errors->first('twitter_access_token_secret') }}</span>
                        </div>
                        <div class="box-footer">
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
