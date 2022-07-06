@extends('admin.layout.master')
@section('title') لیست فروش @endsection
@section('content')
    @push('sale-styles')
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker/daterangepicker.css') }}">
    @endpush
    <!-- begin::main content -->
    <main class="main-content">
        <template>
                <div class="col-6">
                    <input type="text" name="date[]" autocomplete="off"  class="form-control mt-2 date @error('date') is-invalid @enderror">
                    @error('date.*')
                    <strong class="text-danger">
                        {{ $message }}
                    </strong>
                    @enderror
                </div>
                <div class="col-6">
                    <input type="text" autocomplete="off" name="amount[]" id="amount[]"  class="form-control mt-2 @error('amount') is-invalid @enderror" placeholder="مبلغ قسط را مشخص کنید">
                    @error('amount.*')
                    <strong class="text-danger">
                        {{ $message }}
                    </strong>
                    @enderror
                </div>
        </template>
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <p>لطفا تاریخ پرداخت هر قسط و مبلغ آن را مشخص کنید</p>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.update.date',$sale) }}" class="form-group" method="post">
                                @csrf
                                @foreach($sale->payments as $payment)
                                    <div class="form-row" id="node">
                                        <div class="col-6">
                                            <input type="text" name="date[]" value="{{ old('date')[$loop->index] ?? '' }}" autocomplete="off" id="{{ $payment->id }}"  class="form-control mt-2 date @error('date') is-invalid @enderror">
                                            @error('date.*')
                                                <strong class="text-danger">
                                                    {{ $message }}
                                                </strong>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <input type="text" autocomplete="off"  value="{{ old('amount')[$loop->index] ?? '' }}" name="amount[]" id="amount[]"  class="form-control mt-2 @error('amount') is-invalid @enderror" placeholder="مبلغ قسط را مشخص کنید">
                                            @error('amount.*')
                                            <strong class="text-danger">
                                                {{ $message }}
                                            </strong>
                                            @enderror
                                        </div>
                                    </div>
                                @endforeach
                                <div class="d-flex align-items-center">
{{--                                    <button type="button" id="add-input" class="btn btn-primary mt-3 ml-2"><i class="fa fa-plus"></i></button>--}}
                                    <button type="submit" class="btn btn-success mt-3">ایجاد</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">مشخصات کاربری</h3>
                        </div>
                        <div class="card-body">
                            <form action="">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="customer_name">نام مشتری</label>
                                        <input type="text" name="customer_name" id="customer_name" readonly value="{{ $sale->customer->first_name }} {{ $sale->customer->last_name }}" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="insurance_name">نام بیمه مورد نظر</label>
                                        <input type="text" name="insurance_name" id="insurance_name" readonly value="{{ $sale->insuranceType->name }}" class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="count">قیمت کل</label>
                                        <input type="text" name="count" id="count" readonly value="{{ $sale->price }}" class="form-control">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::WWWWWWmain content -->


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
                // $('#add-input').on('click', function (e) {
                //     let clonedNode = $('template').contents().clone();
                //     $('#node').append(clonedNode)
                // })
            })
        </script>
    @endpush

@endsection
