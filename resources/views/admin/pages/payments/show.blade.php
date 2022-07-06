@extends('admin.layout.master')
@section('title') پرداخت اقساط @endsection
@section('content')
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
                            <h3 class="text-right text-black">نمایش اقساط</h3>
                        </div>
                        <div class="card-body">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="type">تاریخ سر رسید</label>
                                        <input type="text" class="form-control" name="due_date" id="due_date" readonly value="{{ \Morilog\Jalali\Jalalian::forge($payment->due_date)->format('Y/m/d') }}">
                                    </div>
                                    <div class="col-6">
                                        <label for="status">وضعیت</label>
                                        <select name="status" disabled id="status" class="form-control">
                                            @foreach(\App\Constants\PaymentStatus::statusList() as $key => $value)
                                                <option {{ $payment->status == $key ? 'selected' : '' }} value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="amount">مبلغ</label>
                                        <input type="text" id="amount" class="form-control" value="{{ $payment->amount }}" readonly>
                                    </div>
                                    <div class="col-6">
                                        <label for="customer">نام کاربر</label>
                                        <input type="text" class="form-control" id="customer" value="{{ $payment->sale->customer->full_name }}" readonly>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->

@endsection
