@extends('layouts.admin')

@section('title', 'Settings')
@section('page-header', 'Settings')

@section('content')
    <div class="row">
        <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Default API Settings</h3>
                </div>
                {{ Form::open(['url'=> route('settings.store')]) }}
                    <div class="box-body">
                        @foreach ($settingFields as $name => $label)
                             <div class="form-group">
                                {{ Form::label($name, $label)}}
                                {{ Form::text($name, $settings->getSettingValueByKey($name), ['class' => 'form-control', 'placeholder' => $label]) }}
                            </div>
                        @endforeach
                        <div class="box-footer">
                            {{ Form::submit('Submit', ['class' => 'btn btn-primary']) }}
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>
    </div>
@endsection
