@extends('layouts.app')
@section('title', 'Image Search')
@section('page-header', 'Image Search')
@section('refresh-button')
    <a href="{{ route('cache', $sectionId.$case->id) }}" class="btn btn-success">Refresh</a>
@endsection
@section('content')
     <div class="inner-info-content image_search">
        @if (!empty($data['messages']))
            <div class="alert alert-danger alert-block">
                <button type="button" class="close" data-dismiss="alert">×</button>
                    <strong>{{ $data['messages'][1] }}</strong>
            </div>
        @endif
        @if(!empty($data['results']['matches']))
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
    @include('layouts.app-partials.flag-buttons')
@endsection
