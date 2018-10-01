@extends('layouts.admin')

@section('title', 'Edit Company')
@section('page-header', 'Edit Company')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Company Info</h3>
                    <a href="{{ route('users.index') }}" title="Back" class="btn btn-sm btn-primary pull-right">
                        <i class="glyphicon glyphicon-fast-backward"></i>
                         Back
                    </a>
                </div>
                 {{ Form::model($company, ['url'=> route('companies.update', $company->id), 'method' => 'PUT']) }}
                    <div class="box-body">
                        <div class="form-group {{ $errors->first('name')?'has-error':'' }}">
                            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Name']) }}
                            <span class="help-block">{{ $errors->first('name') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('website')?'has-error':'' }}">
                            {{ Form::text('website', null, ['class' => 'form-control', 'placeholder' => 'Website']) }}
                            <span class="help-block">{{ $errors->first('website') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('phone')?'has-error':'' }}">
                            {{ Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Phone']) }}
                            <span class="help-block">{{ $errors->first('phone') }}</span>
                        </div>
                        <div class="form-group {{ $errors->first('address')?'has-error':'' }}">
                            {{ Form::text('address', null, ['class' => 'form-control', 'placeholder' => 'Address']) }}
                            <span class="help-block">{{ $errors->first('address') }}</span>
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
