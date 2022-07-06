@extends('admin.layout.master')
@section('title') لیست فروش @endsection
@section('content')
    @push('sale-styles')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker/daterangepicker.css') }}">
    @endpush

    <!-- begin::main content -->
    <main class="main-content">

        <div class="container-fluid">

            <!-- begin::page header -->
            <div class="page-header">
                <div>
                    <h3>@yield('title' ?? '')</h3>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">داشبورد</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title' ?? '') </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end::page header -->
            <div class="row">
                <form action="{{ route('search.result') }}" class="form-group">
                    <div class="form-row">
                        <div class="col-4">
                            <input type="text" class="form-control date" value="{{ old('startDate') }}" autocomplete="off" name="startDate" id="startDate" placeholder="تاریخ شروع">
                        </div>
                        <div class="col-4">
                            <input type="text" class="form-control date" autocomplete="off" value="{{ old('endDate') }}" name="endDate" id="endDate" placeholder="تاریخ پایان">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-info">فیلتر</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">اقساط پرداخت شده</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام مشتری</th>
                                        <th scope="col">نوع بیمه</th>
                                        <th scope="col">تاریخ ثبت</th>
                                        <th class="text-left" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($paidPayments->count() > 0)
                                        @foreach($paidPayments as $payment)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $payment->sale->customer->full_name ?? ''}}</td>
                                                <td>{{ $payment->sale->insuranceType->name ?? '' }}</td>
                                                <td>{{ \Morilog\Jalali\Jalalian::forge($payment->created_at)->format('Y/m/d') ?? ''}}</td>
                                                <td class="text-left">
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('show.payments.status',$payment) }}">نمایش</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>هیچ قسط پرداخت شده ای در بازه تاریخ وارد شده موجود نمیباشد</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">اقساط پرداخت نشده</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام مشتری</th>
                                        <th scope="col">نوع بیمه</th>
                                        <th scope="col">تاریخ ثبت</th>
                                        <th class="text-left" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($unpaidPayments->count() > 0)
                                        @foreach($unpaidPayments as $payment)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $payment->sale->customer->full_name ?? ''}}</td>
                                                <td>{{ $payment->sale->insuranceType->name ?? '' }}</td>
                                                <td>{{ \Morilog\Jalali\Jalalian::forge($payment->created_at)->format('Y/m/d') ?? ''}}</td>
                                                <td class="text-left">
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('show.customer.payment.form',$payment) }}">پرداخت</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>هیچ قسط پرداخت نشده ای در بازه تاریخ وارد شده موجود نمیباشد</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">اقساط پرداخت ناقص</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام مشتری</th>
                                        <th scope="col">نوع بیمه</th>
                                        <th scope="col">تاریخ ثبت</th>
                                        <th class="text-left" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($penndingPayments->count() > 0)
                                        @foreach($penndingPayments as $payment)
                                            <tr>
                                                <th scope="row">{{ $loop->iteration }}</th>
                                                <td>{{ $payment->sale->customer->full_name ?? ''}}</td>
                                                <td>{{ $payment->sale->insuranceType->name ?? '' }}</td>
                                                <td>{{ \Morilog\Jalali\Jalalian::forge($payment->created_at)->format('Y/m/d') ?? ''}}</td>
                                                <td class="text-left">
                                                    <div class="dropdown">
                                                        <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                                           data-toggle="dropdown" aria-haspopup="true"
                                                           aria-expanded="false">
                                                            <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                        </a>
                                                        <div class="dropdown-menu">
                                                            <a class="dropdown-item" href="{{ route('show.customer.payment.form',$payment) }}">پرداخت</a>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <p>هیچ قسط معوقه در بازه تاریخ وارد شده موجود نمیباشد</p>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->
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
