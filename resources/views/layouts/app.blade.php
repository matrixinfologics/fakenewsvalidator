@php
$withoutSidebar = isset($withoutSidebar)??false;
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>
    <!-- Scripts -->
    <script src="{{ asset('js/front.js') }}" defer></script>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        @if(!$withoutSidebar)
            @include('layouts.app-partials.sidebar')
        @endif
        <!-- Page Content  -->
        <div id="content">
            @include('layouts.app-partials.header')
            <!--Info Top---->
            <div class="inner-info">
                <div class="container">
                    @include('layouts.flash-message')
                    <h3 class="info-head">@yield('page-header')</h3>
                    @yield('content')
                </div>
            </div>
        </div>
    </div>
@include('layouts.app-partials.footer')
