@extends('layouts.app', ['withoutSidebar' => true])
@section('title', 'Cases')
@section('page-header', 'Cases')
@section('content')
    <div class="inner-info-content cases">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="case-search-bar col-md-12 col-sm-8 col-xs-11">
                        <div class="row">
                            <input placeholder="Search">
                            <button type="submit"></button>
                        </div>
                    </div>
                  <div class="table-responsive">
                    <table  class="table table-bordered table-hover search-case">
                      <thead>
                        <tr>
                          <th>Title</th>
                          <th>Reported By</th>
                          <th>Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach($cases as $case)
                            <tr>
                              <td><a href="#">{{ $case->title }}</a></td>
                              <td>{{ $case->user? $case->user->name:'' }} {{ $case->created_at->format('d/m/Y h:i') }}</td>
                              <td>In Analysis</td>
                            </tr>
                        @endforeach
                      </tbody>
                    </table>
                  </div><!--end of .table-responsive-->
                </div>
            </div>
        </div>
    </div>
@endsection
