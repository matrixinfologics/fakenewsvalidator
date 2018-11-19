@extends('layouts.admin')

@section('title', $title)
@section('page-header', $title)

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                {!! $grid->show('grid-table') !!}
            </div>
        </div>
    </div>
@endsection
