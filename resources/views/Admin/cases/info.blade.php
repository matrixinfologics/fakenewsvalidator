@extends('layouts.admin')

@section('title', 'Case Info')
@section('page-header', 'Case Info')

@section('content')
    <div class="row">
        @if (isset($case))
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <div class="col-md-10"><h3 class="box-title">{{ $case->title }}</h3></div>
                        <div class="col-md-2">
                            <a href="{{ route('cases.index') }}" title="Back to cases list" class="btn btn-sm btn-warning pull-right">
                                <i class="glyphicon glyphicon-fast-backward"></i> Back
                            </a>
                        </div>
                    </div>
                    <div class="box-body">

                        <dl class="dl-horizontal">
                            <dt>Keywords: </dt>
                            <dd>{{{ $case->keywords }}}</dd>

                            <dt>Url: </dt>
                            <dd>{{{ $case->url }}}</dd>

                            <dt>User: </dt>
                            <dd>{{{ $case->User->name }}}</dd>

                            <dt>Company: </dt>
                            <dd>{{{ $case->User->Company->name }}}</dd>

                            <dt>Fake Flag Count: </dt>
                            <dd>{{{ $case->results()->where('flag', App\NewsCase::FLAG_FAKE)->count() }}}</dd>

                            <dt>Trusted Flag Count: </dt>
                            <dd>{{{ $case->results()->where('flag', App\NewsCase::FLAG_TRUSTED)->count() }}}</dd>
                        </dl>
                        <div class="box-footer with-border">
                            <a href="{{ route('cases.flag', [$case->id, 'flag' => App\NewsCase::FLAG_TRUSTED]) }}" title="Flag Trusted" class="btn btn-sm btn-success pull-right"><i class="fa fa-flag trusted_button"></i>  Flag Trusted</a>
                            <a href="{{ route('cases.flag', [$case->id, 'flag' => App\NewsCase::FLAG_FAKE]) }}" title="Flag Fake" class="btn btn-sm btn-danger pull-left"><i class="fa fa-flag fake_button"></i>  Flag Fake</a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

    </div>
@endsection
