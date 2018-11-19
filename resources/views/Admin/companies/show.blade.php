@extends('layouts.admin')

@section('title', 'Company Info')
@section('page-header', 'Company Info')

@section('content')
    <div class="row">
        @include('Admin.companies.company-info', ['title' => 'Admin Info', 'user' => $company->companyAdmin])
        @include('Admin.users.user-info', ['title' => 'Admin Info', 'user' => $company->companyAdmin])
    </div>
@endsection
