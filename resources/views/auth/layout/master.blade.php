
<!DOCTYPE html>
<html lang="fa">

<!-- Mirrored from v3dboy.ir/previews/html/gramos/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Feb 2022 08:48:27 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ورود</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bundle.css') }}" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}" type="text/css">
    <!-- end::custom styles -->

    <!-- begin::favicon -->
    <link rel="shortcut icon" href="{{ asset('/favicon.ico') }}">
    <!-- end::favicon -->

    <!-- begin::theme color -->
    <meta name="theme-color" content="#3f51b5" />

    <!-- end::theme color -->

</head>
<body class="bg-white h-100-vh p-t-0">

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->

        @yield('content')

<!-- begin::global scripts -->
<script src="{{ asset('admin/assets/vendors/bundle.js') }}"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<!-- end::custom scripts -->

</body>

<!-- Mirrored from v3dboy.ir/previews/html/gramos/login.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Feb 2022 08:48:27 GMT -->
</html>
