@extends('layouts.admin')

@section('title', 'User Listing')
@section('page-header', 'User Listing')

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border col-md-3 pull-right">
                  <a href="{{ route('users.create', Auth::user()->isCompanyAdmin()? ['company' => Auth::user()->company->id]:'') }}" class="btn btn-block btn-primary">Add New User</a>
                </div>
                {!! $grid->show('grid-table') !!}
            </div>
        </div>
    </div>
@endsection
