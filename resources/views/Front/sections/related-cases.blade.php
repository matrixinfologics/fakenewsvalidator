@extends('layouts.app')
@section('title', 'Related Cases')
@section('page-header', 'Related Cases')
@section('content')
    <div class="inner-info-content">
        <div class="row">
            @if(count($relatedCases) > 0)
                @foreach($relatedCases as $case)
                    <div class="col-md-3 border border-dark mr-related">
                        <a href="{{ route('caseinfo', $case->id) }}" title="{{ $case->title }}">
                            <h2>{{ $case->title }}</h2>
                            <div class="case-meta">
                                <p class="author-meta"><strong>By</strong> <i>{{ $case->user->name }}</i> <strong>On </strong> <i>{{ $case->created_at->format('d/m/Y h:i') }} </i> </p>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <p> No item Found </p>
            @endif
        </div>
    </div>
@endsection
