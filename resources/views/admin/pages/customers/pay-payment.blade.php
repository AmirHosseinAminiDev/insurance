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
                            <h3 class="text-right text-black">پرداخت اقساط</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('customer.update.payments',$payment) }}" method="post" enctype="multipart/form-data">
                                @csrf
                                <div class="form-row">
                                    <div class="col-6">
                                        <label for="type">نوع پرداخت</label>
                                        <select name="type" id="type" class="form-control">
                                            @foreach(\App\Constants\PaymentType::payTypeList() as $key => $value)
                                            <option value="{{ $key }}">{{ $value }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <label for="amount">مبلغ</label>
                                        <input type="text" name="amount" id="amount"
                                               class="form-control @error('amount') is-valid @enderror"
                                               placeholder="مبلغ پرداخت شده">
                                        @error('amount')
                                        <div>
                                            <strong class="text-danger">
                                                {{ $message }}
                                            </strong>
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-6">
                                        <label for="attachment">تصویر</label>
                                        <input type="file" name="attachment" id="attachment"
                                               class="form-control @error('attachment') is-invalid @enderror">
                                        @error('attachment')
                                        <div>
                                            <strong class="text-danger">
                                                {{ $message }}
                                            </strong>
                                        </div>
                                        @enderror
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-success mt-2">پرداخت</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->

@endsection
