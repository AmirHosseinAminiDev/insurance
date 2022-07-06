@extends('admin.layout.master')
@section('title') لیست بیمه ها @endsection
@section('content')
    @push('data-tabe-styles')
        <!-- begin::dataTable -->
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/dataTable/responsive.bootstrap.min.css') }}"
              type="text/css">
        <!-- end::dataTable -->
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">ایجاد بیمه جدید</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('insurance.store') }}" class="form-group" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="name">نام بیمه</label>
                                    <input type="text" name="name" id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="نام بیمه را وارد کنید..." value="{{ old('name') }}"
                                           autocomplete="off">
                                    @error('name')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="insurance_code">کد بیمه</label>
                                    <input
                                        type="text"
                                        name="insurance_code"
                                        id="insurance_code"
                                        placeholder="کد بیمه"
                                        value="{{ old('insurance_code') }}"
                                        class="form-control mt-2 @error('insurance_code') is-invalid @enderror">
                                    @error('insurance_code')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-3">ایجاد</button>
                            </form>
                        </div>
                    </div>
                </div>
                @include('admin.pages.insurances.insurance-list', ['insurancesList' => $insurancesList])
            </div>
        </div>

    </main>
    <!-- end::main content -->
@endsection
