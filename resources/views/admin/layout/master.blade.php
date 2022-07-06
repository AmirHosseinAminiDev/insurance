<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        @yield('title')
        |
        مدیریت
    </title>
    <!-- begin::favicon -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <!-- end::favicon -->

    <!-- begin::theme color -->
    <meta name="theme-color" content="#3f51b5"/>
    <!-- end::theme color -->

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bundle.css') }}" type="text/css">
    <!-- end::global styles -->

@stack('sale-styles')
@stack('data-tabe-styles')

<!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}" type="text/css">
    <!-- end::custom styles -->

    @stack('styles')
</head>
<body>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->
@include('admin.partials.sidebar')

@include('admin.partials.navbar')

@yield('content')

<!-- begin::global scripts -->
<script src="{{ asset('admin/assets/vendors/bundle.js') }}"></script>
<!-- end::global scripts -->

@stack('sale-scripts')
@stack('data-table-scripts')

<!-- begin::custom scripts -->
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<!-- end::custom scripts -->

@stack('scripts')
@include('sweet::alert')
</body>

</html>
