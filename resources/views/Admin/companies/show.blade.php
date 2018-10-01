@extends('layouts.admin')

@section('title', 'Company Info')
@section('page-header', 'Company Info')

@section('content')
    <div class="row">
         <div class="col-md-6">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Company Info</h3>
                </div>
                    @if (isset($company))
                        <div class="box-body">
                            <dl class="dl-horizontal">
                                <dt>Name:</dt>
                                <dd>{{{ $company->name }}}</dd>

                                <dt>Website:</dt>
                                <dd>{{{ $company->website }}}</dd>

                                <dt>Phone:</dt>
                                <dd>{{{ $company->phone }}}</dd>

                                <dt>Address:</dt>
                                <dd>{{{ $company->address }}}</dd>

                            </dl>
                             <a href="{{ route('companies.index') }}" title="Back to company list" class="btn btn-sm btn-warning pull-left">
                                <i class="glyphicon glyphicon-fast-backward"></i>
                                 Back
                            </a>
                            <a href="{{ route('companies.edit', $company->id) }}" title="Edit User" class="btn btn-sm btn-primary pull-right">
                                <i class="glyphicon glyphicon-pencil"></i>
                                 Edit Company
                            </a>
                        </div>
                    @endif
            </div>
        </div>
        @include('Admin.users.user-info', ['title' => 'Admin Info', 'user' => $company->companyAdmin])
    </div>
@endsection
