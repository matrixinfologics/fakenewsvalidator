@extends('layouts.admin')

@section('title', 'Companies')
@section('page-header', 'Companies')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border col-md-3 pull-right">
                  <a href="{{ route('companies.create') }}" class="btn btn-block btn-primary">Add New Company</a>
                </div>
                {!! $grid->show('grid-table') !!}
            </div>
        </div>
    </div>
@endsection
