@extends('admin.layout.master')
@section('title') لیست بیمه ها @endsection
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
                            <h3 class="text-right text-black">لیست بیمه های {{ $customer->full_name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th class="text-center" scope="col">#</th>
                                        <th class="text-center" scope="col">نام بیمه</th>
                                        <th class="text-center" scope="col">مبلغ کل</th>
                                        <th class="text-center" scope="col">تعداد اقساط</th>
                                        <th class="text-center" scope="col">عمل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customer->sales()->get() as $sale)
                                        <tr>
                                            <th class="text-center" scope="row">{{ $loop->iteration }}</th>
                                            <td class="text-center">{{ $sale->insuranceType->name }}</td>
                                            <td class="text-center">{{ $sale->price }}</td>
                                            <td class="text-center">{{ $sale->payments->count() }}</td>
                                            <td class="text-center">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-light btn-floating btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('customer.show.payments',$sale) }}">مشاهده اقساط</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
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
