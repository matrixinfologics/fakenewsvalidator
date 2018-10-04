@extends('layouts.admin')

@section('title', 'Add User')
@section('page-header', 'Add User')

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
                {{ Form::open(['url'=> route('users.store')]) }}
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('first_name')?'has-error':'' }}">
                            {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                            <span class="help-block">{{ $errors->first('first_name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('last_name')?'has-error':'' }}">
                            {{ Form::text('last_name', '', ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                            <span class="help-block">{{ $errors->first('last_name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('email')?'has-error':'' }}">
                            {{ Form::email('email', '', ['class' => 'form-control', 'placeholder' => 'Email']) }}
                            <span class="help-block">{{ $errors->first('email') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('role')?'has-error':'' }}">
                            {{ Form::select('role', $roles, $defaultRole, ['class' => Auth::user()->isCompanyAdmin() ? 'form-control select2 readonly':'form-control select2', 'placeholder' => 'Role', 'readonly' => true]) }}
                            <span class="help-block">{{ $errors->first('role') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('password')?'has-error':'' }}">
                            {{ Form::password('password', ['class' => 'form-control', 'placeholder' => 'Password']) }}
                            <span class="help-block">{{ $errors->first('password') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('password_confirmation')?'has-error':'' }}">
                            {{ Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm Password']) }}
                            <span class="help-block">{{ $errors->first('password_confirmation') }}</span>
                        </div>
                        <div class="form-group has-warning" id="user_companies" style="display: none;">
                            {{ Form::select('company', $companies, $defaultCompany, ['class' => Auth::user()->isCompanyAdmin() ? 'form-control select2 readonly':'form-control select2', 'placeholder' => 'Company']) }}
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
