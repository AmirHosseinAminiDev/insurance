@extends('admin.layout.master')
@section('title') لیست مشتریان @endsection
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
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">ایجاد مشتری جدید</h3>

                        </div>
                        <div class="card-body">
                            <form action="{{ route('customer.store') }}" class="form-group" method="post">
                                @csrf
                                <label for="first_name">نام</label>
                                <input type="text" name="first_name" id="first_name" class="form-control @error('first_name') is-invalid @enderror" placeholder="نام مشتری را وارد کنید..." value="{{ old('first_name') }}" autocomplete="off">
                                @error('first_name')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                @enderror
                                <label for="last_name" class="mt-2">نام خانوادگی</label>
                                <input type="text" name="last_name" id="last_name" class="form-control @error('last_name') is-invalid @enderror" placeholder="نام خانوادگی مشتری را وارد کنید..." value="{{ old('last_name') }}" autocomplete="off">
                                @error('last_name')
                                   <div>
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                   </div>
                                @enderror
                                <label for="national_code" class="mt-2">کد ملی</label>
                                <input type="text" name="national_code" id="national_code" class="form-control @error('national_code') is-invalid @enderror" placeholder="کدملی مشتری را وارد کنید..." value="{{ old('national_code') }}" autocomplete="off">
                                @error('national_code')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                @enderror
                                <label for="mobile" class="mt-2">شماره موبایل</label>
                                <input type="text" name="mobile" id="mobile" class="form-control @error('mobile') is-invalid @enderror" placeholder="شماره موبایل مشتری را وارد کنید..." value="{{ old('mobile') }}" autocomplete="off">
                                @error('mobile')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                @enderror
                                <button type="submit" class="btn btn-success mt-3">ایجاد</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">لیست مشتریان</h3>
                            <form action="">
                                <div class="form-row">
                                    <div class="col-8">
                                        <input type="text" name="search" class="form-control" placeholder="جستجوی مشتری بر اساس نام ، شماره موبایل ، کد ملی">

                                    </div>
                                    <div class="col-4">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-search ml-2"></i>
                                            جستجو
                                        </button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">نام</th>
                                        <th scope="col">نام خانوادگی</th>
                                        <th scope="col">کد ملی</th>
                                        <th scope="col">شماره موبایل</th>
                                        <th class="text-left" scope="col">عمل</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($customersList as $customer)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $customer->first_name }}</td>
                                        <td>{{ $customer->last_name }}</td>
                                        <td>{{ $customer->national_code }}</td>
                                        <td>{{ $customer->mobile }}</td>
                                        <td class="text-left">
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-light btn-floating btn-icon btn-sm" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                </a>
                                                <div class="dropdown-menu">
                                                    <a class="dropdown-item" href="{{ route('show.customer.insurances',$customer) }}">بیمه ها</a>
                                                    <form action="{{ route('customer.destroy',$customer) }}" class="d-none" id="delete-{{ $customer->id }}-customer" method="post">
                                                        @csrf
                                                        @method('DELETE')
                                                    </form>
                                                    <a class="dropdown-item" href="#" onclick="return confirm('آیا مطمئن هستید؟') ? document.getElementById('delete-{{ $customer->id }}-customer').submit() : ''">حذف</a>
                                                    <a class="dropdown-item" href="{{ route('customer.edit',$customer) }}">ویرایش</a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $customersList->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->
@endsection
