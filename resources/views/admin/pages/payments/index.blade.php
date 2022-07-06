@extends('admin.layout.master')
@section('title') لیست پرداخت ها @endsection
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
                            <h3 class="text-right text-black">لیست آخرین پرداختی ها</h3>
                            <form action="" id="dateRangeFilter" class="form-group">
                                <div class="align-items-end form-row">
                                    <div class="col-8">
                                        <div class="form-row">
                                            <div class="col-3">
                                                <label for="dateRangeFilter">فیلتر بر اساس تاریخ :</label>
                                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                                       name="startDate"
                                                       id="startDate" placeholder="تاریخ شروع">
                                            </div>
                                            <div class="col-3">
                                                <label for="dateRangeFilter">فیلتر بر اساس تاریخ :</label>

                                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                                       name="endDate"
                                                       id="endDate" placeholder="تاریخ پایان">
                                            </div>
                                            <div class="col-3">
                                                <label for="sortFilter">فیلتر بر اساس :</label>
                                                <select name="sortFilter" id="sortFilter" class="form-control mt-2">
                                                    <option value="all">همه</option>
                                                    @foreach(\App\Constants\PaymentStatus::statusList() as $key => $value)
                                                        <option value="{{ $key }}" {{ request('sortFilter') == $key ? 'selected' : '' }}>{{ $value }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="statusPayment">وضعیت پرداختی :</label>
                                                <select name="statusPayment" id="statusPayment" class="form-control mt-2">
                                                    <option value="all">همه</option>
                                                    <option value="today" {{ request('statusPayment') == 'today' ? 'selected' : '' }}>سررسیده</option>
                                                    <option value="expire" {{ request('statusPayment') == 'expire' ? 'selected' : '' }}>معوقه</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-info mt-2">فیلتر</button>

                                </div>
                            </form>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام مشتری</th>
                                        <th scope="col">نوع بیمه</th>
                                        <th scope="col">نوع پرداخت</th>
                                        <th scope="col">تاریخ سر رسید</th>
                                        <th scope="col" class="text-center">وضعیت</th>
                                        <th class="text-left" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($payments as $payment)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $payment->sale->customer->full_name }}</td>
                                            <td>{{ $payment->sale->insuranceType->name ?? '' }}</td>
                                            <td>{{ \App\Constants\SaleType::statusList()[$payment->sale->pay_type] ?? '' }}</td>
                                            <td>{{ \Morilog\Jalali\Jalalian::forge($payment->due_date)->format('Y/m/d') ?? ''}}</td>
                                            <td class="text-center">
                                                @switch($payment->status)
                                                    @case(\App\Constants\PaymentStatus::PAID)
                                                        <span class="badge badge-success">{{ \App\Constants\PaymentStatus::statusList()['paid'] }}</span>
                                                    @break
                                                    @case(\App\Constants\PaymentStatus::UNPAID)
                                                        <span class="badge badge-danger">{{ \App\Constants\PaymentStatus::statusList()['unpaid'] }}</span>
                                                        @break
                                                    @case(\App\Constants\PaymentStatus::PENDING)
                                                        <span class="badge badge-warning">{{ \App\Constants\PaymentStatus::statusList()['pending'] }}</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td class="text-left">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item"
                                                           href="{{ route('show.payments.status',$payment) }}">ویرایش</a>
                                                        <form action="{{ route('sales.delete',$payment) }}"
                                                              method="post"
                                                              id="delete-{{ $payment->id }}-payment" class="d-none">
                                                            @csrf
                                                        </form>
                                                        <a href="{{ route('payments.show',$payment) }}"
                                                           class="dropdown-item">نمایش</a>
                                                        @if($payment->status == 'unpaid')
                                                            <a href="{{ route('update.payments.status',$payment) }}"></a>
                                                        @else
                                                            <strong class="dropdown-item text-success">
                                                                پرداخت شده
                                                            </strong>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $payments->links('pagination::bootstrap-4') }}
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
