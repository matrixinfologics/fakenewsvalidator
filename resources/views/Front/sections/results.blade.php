@extends('layouts.app')
@section('title', 'Case Results')
@section('page-header', 'Case Results')
@section('content')
@php
    $totalResults = $case->sectionFakeResults()->count() + $case->sectionTrustedResults()->count();
    $fakePrecentage = 0;
    if($totalResults > 0){
        $fakePrecentage = ($case->sectionFakeResults()->count()/$totalResults)*100;
    }

@endphp
    <div class="inner-info-content">
        <table class="table table-striped case_results">
            <thead>
                <tr>
                    <th></th>
                    <th>Fake News</th>
                    <th>Trusted News</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sections as $sectionId => $section)
                    <tr>
                        <td>{{ $section }}</td>
                        <td>{{ $case->sectionFakeResults()->where('section_id', $sectionId)->count() }}</td>
                        <td>{{ $case->sectionTrustedResults()->where('section_id', $sectionId)->count() }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <h3>This news is {{ round($fakePrecentage) }}% fake.</h3>
    </div>
    <div class="inner-info-content flag_button">
        {{ Form::open(['url'=> route('flag-case', $case->id), 'class' => 'flag_trusted']) }}
            {{ Form::hidden('flag', 'trusted')}}
            {{ Form::button('FLAG TRUSTED', ['type' => 'submit', 'class' => 'btn btn-flag pull-left']) }}
        {{ Form::close() }}
        {{ Form::open(['url'=> route('flag-case', $case->id), 'class' => 'flag_fake']) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>
@endsection
