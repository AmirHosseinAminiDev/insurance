@extends('admin.layout.master')
@section('title') داشبورد @endsection
@push('sale-styles')
    <link rel="stylesheet"
          href="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker/daterangepicker.css') }}">
@endpush
@section('content')
    <!-- begin::main content -->
    <main class="main-content">

        <div class="container-fluid">

            <!-- begin::page header -->
            <div class="page-header">
                <div>
                    <h3>@yield('title')</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item active" aria-current="page">داشبورد</li>
                        </ol>
                    </nav>
                    <form action="{{ route('admin.dashboard') }}" id="dateRangeFilter" class="form-group">
                        <label for="dateRangeFilter">فیلتر بر اساس تاریخ :</label>

                        <div class="row">
                            <div class="col-4">
                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                       name="startDate"
                                       value="{{ request('startDate') ?? '' }}"
                                       id="startDate" placeholder="تاریخ شروع">
                            </div>
                            <div class="col-4">
                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                       value="{{ request('endDate') ?? '' }}"
                                       name="endDate"
                                       id="endDate" placeholder="تاریخ پایان">
                            </div>
                            <div class="col-3">
                                <button class="btn btn-info mt-2">فیلتر</button>
                            </div>
                        </div>

                    </form>
                </div>

            </div>
            <!-- end::page header -->

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-info-gradient icon-block-floating">
                                    <i class="fa fa-user-o"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ $customersCount }}</h3>
                                <p>مجموع مشتریان</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-success-gradient icon-block-floating">
                                    <i class="fa fa-rocket"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ $insurancesCount }}</h3>
                                <p>تعداد فروش</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-danger-gradient icon-block-floating">
                                    <i class="fa fa-star"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ number_format($saleAmount) . ' تومان' }}</h3>
                                <p>مبلغ کل فروش</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-warning-gradient icon-block-floating">
                                    <i class="fa fa-credit-card"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ number_format($cashSaleAmount) . ' تومان' }}</h3>
                                <p>مبلغ فروش نقدی</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-warning-gradient icon-block-floating">
                                    <i class="fa fa-calendar"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ number_format($installmentSaleAmount) . ' تومان' }}</h3>
                                <p>مبلغ فروش اقساطی</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-warning-gradient icon-block-floating">
                                    <i class="fa fa-money"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ number_format($paidInstallment) . ' تومان' }}</h3>
                                <p>اقساط وصول شده</p>
                            </div>
                        </div>

                    </div>
                    <div class="col-md-3">

                        <div class="card text-center">
                            <div class="card-body">
                                <div class="icon-block icon-block-xl m-b-20 bg-warning-gradient icon-block-floating">
                                    <i class="fa fa-money"></i>
                                </div>
                                <h3 class="font-weight-800 primary-font">{{ number_format($lateInstallment) . ' تومان' }}</h3>
                                <p>اقساط معوقه</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>

    </main>
@endsection
@push('sale-scripts')
    <!-- begin::datepicker -->
    <script src="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.fa.min.js') }}"></script>
    <script src="{{ asset('admin/assets/vendors/datepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('admin/assets/js/examples/datepicker.js') }}"></script>
    <!-- end::datepicker -->
    <script>
        $(document).ready(function () {
            $('.date').datepicker({
                dateFormat: 'yy/mm/dd',
            })
        })
    </script>
@endpush
