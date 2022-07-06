<!DOCTYPE html>
<html lang="fa">

<!-- Mirrored from v3dboy.ir/previews/html/gramos/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Feb 2022 08:48:28 GMT -->
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>رسید پرداخت</title>

    <!-- begin::global styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/bundle.css') }}" type="text/css">
    <!-- end::global styles -->

    <!-- begin::custom styles -->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/app.css') }}" type="text/css">
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}" type="text/css">
    <!-- end::custom styles -->

    <!-- begin::favicon -->
    <link rel="shortcut icon" href="{{ asset('admin/assets/media/image/favicon.png') }}">
    <!-- end::favicon -->

    <!-- begin::theme color -->
    <meta name="theme-color" content="#3f51b5"/>
    <!-- end::theme color -->

</head>
<body>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->

<main class="main-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-50">
                <div class="invoice">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-left m-b-0 primary-font">صورتحساب</h3>
                    </div>
                    <ul>
                        <li class="d-flex justify-content-between w-100 align-items-center mb-2 mt-2">
                            <span>
                                توضیحات
                            </span>
                            <span>
                                {{ $payment->sale->insuranceType->name }}
                            </span>
                        </li>
                        <li class="d-flex justify-content-between w-100 align-items-center mb-2">
                            <span>
                                قیمت
                            </span>
                            <span>
                                {{ number_format($payment->amount) }} تومان
                            </span>
                        </li>
                        <li class="d-flex justify-content-between w-100 align-items-center ">
                            <span>
                                جمع کل
                            </span>
                            <span>
                                {{ number_format($payment->amount) }} تومان
                            </span>
                        </li>
                    </ul>
                </div>
                <div class="text-left d-print-none">
                    <hr class="m-t-b-50">
                    @if($payment->status == 'unpaid' || $payment->status == 'pendding')
                        <form action="{{ route('purchase.store') }}" method="post">
                            @csrf
                            <input type="hidden" name="payment" value="{{ $payment->id }}">
                            <button class="btn btn-primary">
                                <i class="fa fa-send m-l-5"></i>پرداخت
                            </button>
                        </form>
                    @else
                        <strong class="text-success">
                            پرداخت شده
                        </strong>
                    @endif
                    <a href="javascript:window.print()" class="btn btn-success m-r-5 mt-2">
                        <i class="fa fa-print m-l-5"></i> چاپ
                    </a>
                </div>
            </div>
        </div>

    </div>

</main>
<!-- end::main content -->

<!-- begin::global scripts -->
<script src="{{ asset('admin/assets/vendors/bundle.js') }}"></script>
<!-- end::global scripts -->

<!-- begin::custom scripts -->
<script src="{{ asset('admin/assets/js/custom.js') }}"></script>
<script src="{{ asset('admin/assets/js/app.js') }}"></script>
<!-- end::custom scripts -->

</body>

<!-- Mirrored from v3dboy.ir/previews/html/gramos/invoice.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 16 Feb 2022 08:48:28 GMT -->
</html>
