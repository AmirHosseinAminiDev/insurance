@extends('admin.layout.master')
@section('title') ویرایش بیمه @endsection
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
                            <li class="breadcrumb-item"><a href="#">داشبورد</a></li>
                            <li class="breadcrumb-item"><a href="#">رابط کاربری</a></li>
                            <li class="breadcrumb-item"><a href="#">جدول‌ها</a></li>
                            <li class="breadcrumb-item active" aria-current="page">جدول داده</li>
                        </ol>
                    </nav>
                </div>
            </div>
            <!-- end::page header -->

            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">@yield('title')</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('insurance.update',$insurance->id) }}" class="form-group"
                                  method="post">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="name">نام بیمه</label>
                                    <input type="text" name="name" id="name"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="نام بیمه را وارد کنید..." value="{{ $insurance->name ?? '' }}"
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
                                        value="{{ $insurance->insurance_code }}"
                                        class="form-control mt-2 @error('insurance_code') is-invalid @enderror">
                                    @error('insurance_code')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-3">ویرایش</button>
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
