<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400italic,600,700%7COpen+Sans:300,400,400italic,600,700">
    <link href="{{ asset('backend/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/oneui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/css/themes/admin.css') }}" rel="stylesheet">
    <link href="{{ asset('backend/assets/js/plugins/summernote/summernote.min.css') }}" rel="stylesheet">
    @yield('css')
    <script defer src="//use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
</head>
<body>

<div id="page-container" class="sidebar-l sidebar-o side-scroll header-navbar-fixed">
    
    @include('admin._navigation')

    <main id="main-container">
        <div class="content bg-gray-lighter">
            <div class="row items-push">
                <div class="col-sm-7">
                    <h1 class="page-heading">
                        @yield('title', '')
                        <small>@yield('subtitle', '')</small>
                    </h1>
                </div>
            </div>
        </div>
        <div class="content">
            @yield('content')
        </div>

    </main>
</div>


<script src="{{ asset('backend/assets/js/oneui.min.js') }}"></script>
<script src="{{ asset('backend/assets/js/plugins/summernote/summernote.min.js') }}"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@include('admin._alert')

@yield('script')
@stack('stack-script')
@yield('alert')

</body>
</html>
