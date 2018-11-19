@extends('layouts.app', ['withoutSidebar' => true])
@section('title', 'Cases')
@section('page-header', 'Cases')
@section('content')
    <div class="inner-info-content cases">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12">
                    <div class="case-search-bar col-md-12">
                        <div class="row">
                            {{ Form::open(['method' => 'GET', 'url'=> route('cases')]) }}
                                {{ Form::text('s', request()->has('s')? request()->get('s'):null, ['placeholder' => 'Search']) }}
                                {{ Form::button('', ['type' => 'submit']) }}
                            {{ Form::close() }}
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
                        @if(!$cases->isEmpty())
                            @foreach($cases as $case)
                                <tr>
                                  <td><a href="{{ route('caseinfo', $case->id) }}" title="{{ $case->title }}">{{ $case->title }}</a></td>
                                  <td>{{ $case->user? $case->user->name:'' }} {{ $case->created_at->format('d/m/Y h:i') }}</td>
                                  <td>{{ $case->flagStatus }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="3">No Result Found</td>
                            </tr>
                        @endif
                      </tbody>
                    </table>
                    {{ $cases->appends(['s' => request()->get('s')])->links() }}
                  </div><!--end of .table-responsive-->
                </div>
            </div>
        </div>
    </div>
@endsection
