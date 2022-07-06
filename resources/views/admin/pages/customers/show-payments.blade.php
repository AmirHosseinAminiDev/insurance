@extends('admin.layout.master')
@section('title') لیست اقساط {{ $sale->customer->full_name }}@endsection
@section('content')
    @push('sale-styles')
        <link rel="stylesheet"
              href="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css') }}">
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
                            <li class="breadcrumb-item"><a
                                    href="{{ route('show.customer.insurances',$sale->customer) }}">لیست اقساط</a></li>
                            <li class="breadcrumb-item active" aria-current="page">@yield('title' ?? '') </li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end::page header -->

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-6">
                                    <h3 class="text-right text-black">لیست اقساط</h3>
                                    <a href="{{ route('customer.bulk.payments',$sale) }}" class="btn btn-info">پرداخت
                                        یکجا</a>
                                </div>
                                <div class="col-md-6">
                                    <form action="{{ route('customer.show.payments', $sale) }}" method="get"
                                          id="dateRangeFilter">
                                        <div class="form-row">
                                            <div class="col-7">
                                                <label for="dateRangeFilter">فیلتر بر اساس تاریخ :</label>
                                                <div class="form-row">
                                                    <div class="col-4">
                                                        <input type="text" class="form-control date mt-2"
                                                               autocomplete="off"
                                                               name="startDate"
                                                               value="{{ request('startDate') ?? '' }}"
                                                               id="startDate" placeholder="تاریخ شروع">
                                                        @error('startDate')
                                                        <span class="badge badge-danger"> {{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="text" class="form-control date mt-2"
                                                               value="{{ request('endDate') ?? '' }}"
                                                               autocomplete="off"
                                                               name="endDate"
                                                               id="endDate" placeholder="تاریخ پایان">
                                                    </div>
                                                    <div class="col-4">
                                                        <button class="btn btn-info mt-2">فیلتر</button>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <label for="sortFilter">فیلتر بر اساس :</label>
                                                <select name="sortFilter" id="sortFilter" class="form-control mt-2">
                                                    <option value="all">همه</option>
                                                    @foreach(\App\Constants\PaymentStatus::statusList() as $key => $value)
                                                        <option
                                                            value="{{ $key }}" {{ request('sortFilter') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">تاریخ سر رسید</th>
                                        <th class="text-center" scope="col">مبلغ</th>
                                        <th class="text-center" scope="col">وضعیت</th>
                                        <th class="text-center" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if($sale->payments->count() > 0)
                                        @foreach($payments as $payment)
                                            <tr>
                                                <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                                <td class="text-center">{{ \Morilog\Jalali\Jalalian::forge($payment->due_date)->format('Y/m/d') }}</td>
                                                <td class="text-center">{{ $payment->amount  }} تومان</td>
                                                <td>
                                                    <span
                                                        class="badge badge-{{ \App\Constants\PaymentStatus::showBadge()[$payment->status] }}">{{ \App\Constants\PaymentStatus::statusList()[$payment->status] }}</span>
                                                </td>
                                                <td class="text-center">

                                                    <div class="dropdown">
                                                        @if($payment->status == 'paid')
                                                            <a class="dropdown-item" href="#">
                                                                پرداخت شده
                                                            </a>
                                                        @else
                                                            <a href="#"
                                                               class="btn btn-light btn-floating btn-icon btn-sm"
                                                               data-toggle="dropdown" aria-haspopup="true"
                                                               aria-expanded="false">
                                                                <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                            </a>
                                                            <div class="dropdown-menu">
                                                                <a class="dropdown-item"
                                                                   href="{{ route('show.customer.payment.form',$payment) }}">پرداخت</a>
                                                                <a class="dropdown-item"
                                                                   href="{{ route('show.payments.status',$payment) }}">ویرایش</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <h3 class="text-center">شما هیچ قسطی جهت پرداخت ندارید</h3>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        {{ $payments->links('pagination::bootstrap-4') }}
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
