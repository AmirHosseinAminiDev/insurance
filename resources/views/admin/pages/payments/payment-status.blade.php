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
    <style>
        #main-content{
            background-color: #EFF2FA;
        }
        .main-content .checkout {
            max-width: 100%;
            border-radius: 8px;
            -webkit-box-shadow: 0 2px 4px 0 rgb(0 0 0 / 10%);
            box-shadow: 0 2px 4px 0 rgb(0 0 0 / 10%);
            padding: 10px 18px;
            -webkit-border-radius: 5px;
            -moz-border-radius: 5px;
            border-radius: 5px;
            background-color: #fff;
        }

        .fa.fa-check{
            font-size: 50px;
        }
    </style>
    <!-- end::theme color -->

</head>
<body>

<!-- begin::page loader-->
<div class="page-loader">
    <div class="spinner-border"></div>
    <span>در حال بارگذاری ...</span>
</div>
<!-- end::page loader -->

<main class="main-content mr-0">
    <div class="container">
        <div class="row">
            @if($gateway->status == \App\Constants\GatewayStatus::SUCCESS)
                <div class="col-md-12">
                    <div class="w-100 checkout">
                        <div class="text-center mt-3">
                            <div class="icon-success">
                                <i class="fa fa-check fa-2x text-success"></i>
                            </div>
                            <div class="order-success mb-3">
                                <div class="h4 font-weight-bold mb-4">{{ __('messages.success.gateway.success-payment') }}</div>
                                <div class="font-weight-bold mb-12">{{ __('messages.success.gateway.payment-detail') }}</div>
                                <ul class="mt-2">
                                    <li class="mt-2"> شماره پیگیری :
                                        <bdi>
                                            {{ $gateway->transaction_id }}
                                        </bdi>
                                    </li>
                                    <li class="mt-2">وضعیت :
                                        <span class="badge badge-success">{{ \App\Constants\GatewayStatus::statusList()['success'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-md-12">
                    <div class="w-100 checkout">
                        <div class="text-center mt-3">
                            <div class="icon-success">
                                <i class="fa fa-close fa-3x text-danger"></i>
                            </div>
                            <div class="order-success mb-3">
                                <div class="h4 font-weight-bold mb-4">{{ __('messages.error.gateway.error-payment') }}</div>
                                <div class="font-weight-bold mb-12">{{ __('messages.error.gateway.payment-detail') }}</div>
                                <ul class="mt-2">
                                    <li class="mt-2"> شماره پیگیری :
                                        <bdi>
                                            {{ $gateway->transaction_id }}
                                        </bdi>
                                    </li>
                                    <li class="mt-2">وضعیت :
                                        <span class="badge badge-danger">{{ \App\Constants\GatewayStatus::statusList()['failed'] }}</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
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
