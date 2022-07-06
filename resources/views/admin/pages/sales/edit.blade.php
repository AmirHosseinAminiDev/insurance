@extends('admin.layout.master')
@section('title') ویرایش فروش @endsection
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
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">مشخصات فروش</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.update',$sale) }}" method="post">
                                @csrf
                                <input type="hidden" name="count" value="{{ $sale->payments->count() }}">
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="customer_id">نام مشتری</label>
                                        <select name="customer_id" id="customer_id" class="form-control">
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}" {{ $customer->id == $sale->customer_id ? 'selected' : '' }}>{{ $customer->full_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="insurance_type_id">نام بیمه مورد نظر</label>
                                        <select name="insurance_type_id" id="insurance_type_id" class="form-control">
                                            @foreach($insurances as $insurance)
                                                <option value="{{ $insurance->id }}" {{ $insurance->id == $sale->insurance_type_id ? 'selected' : '' }}>{{ $insurance->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="price">قیمت کل</label>
                                        <input type="text" name="price" id="price" value="{{ $sale->price }}"
                                               class="form-control">
                                    </div>
                                    <div class="col-6">
                                        <label for="pay_type">نوع پرداخت</label>
                                        <select name="pay_type" id="pay_type" class="form-control">
                                            @foreach(\App\Constants\SaleType::toArray() as $type)
                                                <option value="{{$type}}" {{ $sale->pay_type ==  $type  ? 'selected' : '' }}>
                                                    {{\App\Constants\SaleType::statusList()[$type]}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-info mt-3">ویرایش</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>

@endsection
