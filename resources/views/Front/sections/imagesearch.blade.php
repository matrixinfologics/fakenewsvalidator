@extends('layouts.app')
@section('title', 'Image Search')
@section('page-header', 'Image Search')
@section('content')
    <div class="inner-info-content image_upload_form">
        {{ Form::open(['url'=> route('image-search', $case->id), 'files' => true]) }}
            {{ Form::file('image', array('class' => 'image')) }}
            {{ Form::button('Upload', ['type' => 'submit', 'class' => 'btn btn-primary pull-right']) }}
        {{ Form::close() }}
    </div>
     <div class="inner-info-content image_search">
        @if(!empty($data))
            @foreach($data['results']['matches'] as $image)
                <div class="row">
                    <div class="col-md-2">
                        <div class="tineye_img">
                           <img src="{{ $image['image_url'] }}"/>
                            <p>{{ $image['format'].', '.$image['width'].'x'.$image['height'].', '.round($image['size']/1024/8).'    KB' }}</p>
                        </div>
                    </div>
                    <div class="col-md-10">
                        <div class="tineye_img_info">
                            <p><a href="http://{{ $image['domain'] }}" title="{{ $image['domain'] }}" target="_blank">{{ $image['domain'] }}</a></p>
                            <p><strong>Filename:</strong> <a href="{{ $image['backlinks'][0]['url'] }}" title="{{ basename($image['backlinks'][0]['url']) }}" target="_blank">{{ substr(basename($image['backlinks'][0]['url']), 0, 80) }}</a></p>
                            <p><strong>Found on:</strong> <a href="{{ $image['backlinks'][0]['backlink'] }}" title="{{ basename($image['backlinks'][0]['backlink']) }}" target="_blank">{{ substr(basename($image['backlinks'][0]['backlink']), 0, 80) }}</a></p>
                            <p>Page crawled on {{ date('m d, Y', strtotime($image['backlinks'][0]['crawl_date'])) }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No item found</p>
        @endif
    </div>
    <div class="inner-info-content flag_button">
        {{ Form::open(['url'=> route('section-flag', [$sectionId, $case->id])]) }}
            {{ Form::hidden('flag', 'fake')}}
            {{ Form::button('FLAG FAKE', ['type' => 'submit', 'class' => 'btn btn-flag pull-right']) }}
        {{ Form::close() }}
    </div>
@endsection
