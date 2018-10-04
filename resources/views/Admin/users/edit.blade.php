@extends('layouts.admin')

@section('title', 'Edit User')
@section('page-header', 'Edit User')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">User Info</h3>
                    <a href="{{ route('users.index') }}" title="Back" class="btn btn-sm btn-primary pull-right">
                        <i class="glyphicon glyphicon-fast-backward"></i>
                         Back
                    </a>
                </div>
                 {{ Form::model($user, ['url'=> route('users.update', $user->id), 'method' => 'PUT']) }}
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('first_name')?'has-error':'' }}">
                            {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('last_name')?'has-error':'' }}">
                            {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('email')?'has-error':'' }}">
                            {{ Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Email']) }}
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('role')?'has-error':'' }}">
                            {{ Form::select('role', $roles, null, ['class' =>  Auth::user()->isCompanyAdmin() ? 'form-control select2 readonly':'form-control select2', 'placeholder' => 'Role']) }}
                            <span class="help-block">{{ $errors->first('role') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('password')?'has-error':'has-warning' }}">
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                            @if ($errors->first('password'))
                                <span class="help-block">{{ $errors->first('password') }}</span>
                            @else
                                <span class="help-block"><i class="glyphicon glyphicon-question-sign"></i> Leave blank if you don't want to change password.</span>
                            @endif
                        </div>
                        <div class="form-group {{ $errors->first('password_confirmation')?'has-error':'' }}">
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        </div>
                        <div class="form-group has-warning" id="user_companies" style="display: none;">
                            {{ Form::select('company', $companies, isset($user->company) ?$user->company->id: null, ['class' =>  Auth::user()->isCompanyAdmin() ? 'form-control select2 readonly':'form-control select2', 'placeholder' => 'Company']) }}
                            <span class="help-block"><i class="glyphicon glyphicon-question-sign"></i> Leave blank if you don't want to assign company.</span>
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
