@extends('admin.layout.master')
@section('title') لیست فروش @endsection
@section('content')
    @push('sale-styles')
        <link rel="stylesheet"
              href="{{ asset('admin/assets/vendors/datepicker-jalali/bootstrap-datepicker.min.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/datepicker/daterangepicker.css') }}">
        <link rel="stylesheet" href="{{ asset('admin/assets/vendors/select2/css/select2.min.css') }}">
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
                            <h3 class="text-right text-black">فروش بیمه جدید</h3>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('sales.store') }}" class="form-group" method="post">
                                @csrf
                                <div class="form-group">
                                    <label for="customer_id">مشتری</label>
                                    <select name="customer_id" id="customer_id"
                                            class="form-control @error('customer_id') is-invalid @enderror">
                                        @if($customers->count() > 0)
                                            @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->full_name }}</option>
                                            @endforeach
                                        @else
                                            <option value="" disabled>هیچ مشتری تعریف نشده است</option>
                                        @endif
                                    </select>
                                    @error('customer_id')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="insurance_type_id">نوع بیمه</label>
                                    <select name="insurance_type_id" id="insurance_type_id"
                                            class="form-control @error('insurance_type_id') is-invalid @enderror">
                                        @forelse($insurances as $insurance)
                                            <option value="{{ $insurance->id }}">{{ $insurance->name }}</option>
                                        @empty
                                            <option value="">هیچ بیمه ای تعریف نشده است</option>
                                        @endforelse
                                    </select>
                                    @error('insurance_type_id')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="pay_type">نوع پرداخت</label>
                                    <select name="pay_type" id="pay_type"
                                            class="form-control @error('pay_type') is-invalid @enderror">
                                        @foreach(\App\Constants\SaleType::toArray() as $type)
                                            <option value="{{$type}}">
                                                {{\App\Constants\SaleType::statusList()[$type]}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="price" class="mt-2">قیمت کل</label>
                                    <input type="text" name="price" autocomplete="off" id="price"
                                           class="form-control @error('price') is-invalid @enderror"
                                           placeholder="قیمت کل قسط را وارد کنید" value="{{ old('price') }}">
                                    @error('price')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <div id="installment-count" class="d-none">
                                        <label for="count" class="mt-2">تعداد اقساط</label>
                                        <input type="number" autocomplete="off" name="count" id="count"
                                               class="form-control @error('count') is-invalid @enderror"
                                               placeholder="تعداد کل اقساط را وارد کنید" value="{{ old('count') }}">
                                    </div>
                                    @error('count')
                                    <div>
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    </div>
                                    @enderror
                                </div>
                                <button type="submit" class="btn btn-success mt-3">ایجاد</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="text-right text-black">لیست آخرین فروش ها</h3>
                            <div class="form-row">
                                <div class="col-12">
                                    <form action="" id="dateRangeFilter" class="form-group">
                                        <div class="form-row align-items-center">
                                            <div class="col-3">
                                                <label for="dateRangeFilter">تاریخ شروع :</label>
                                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                                       name="startDate"
                                                       value="{{ request('startDate') ?? '' }}"
                                                       id="startDate" placeholder="تاریخ شروع">
                                            </div>
                                            <div class="col-3">
                                                <label for="dateRangeFilter">تاریخ پایان :</label>
                                                <input type="text" class="form-control date mt-2" autocomplete="off"
                                                       name="endDate"
                                                       value="{{ request('endDate') ?? '' }}"
                                                       id="endDate" placeholder="تاریخ پایان">
                                            </div>
                                            <div class="col-3">
                                                <label for="dateRangeFilter">نوع بیمه :</label>
                                                <select name="insuranceType" id="insuranceType"
                                                        class="mt-2 form-control">
                                                    <option value="all">همه</option>
                                                    @foreach($insurances as $insurance)
                                                        <option
                                                            value="{{ $insurance->name }}" {{ request('insuranceType') == $insurance->name ? 'selected' : '' }}>{{ $insurance->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-3">
                                                <label for="dateRangeFilter">انتخاب کاربر :</label>
                                                <select name="customer" id="customer" class="mt-2 form-control">
                                                    <option value="all">همه</option>
                                                    @foreach($customers as $customer)
                                                        <option
                                                            value="{{ $customer->id }}" {{ request('customer') == $customer->first_name. ' '.$customer->last_name ? 'selected' : '' }}>{{ $customer->first_name. ' ' .$customer->last_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <button class="btn btn-info mt-2">فیلتر</button>
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
                                        <th scope="col">#</th>
                                        <th scope="col">نام مشتری</th>
                                        <th scope="col">نوع بیمه</th>
                                        <th scope="col">نوع پرداخت</th>
                                        <th scope="col">تاریخ ثبت</th>
                                        <th class="text-left" scope="col">عملیات</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($sales as $sale)
                                        <tr>
                                            <th scope="row">{{ $loop->iteration }}</th>
                                            <td>{{ $sale->customer->full_name }}</td>
                                            <td>{{ $sale->insuranceType->name ?? '' }}</td>
                                            <td>{{ \App\Constants\SaleType::statusList()[$sale->pay_type] ?? '' }}</td>
                                            <td>{{ \Morilog\Jalali\Jalalian::forge($sale->created_at)->format('Y/m/d') ?? ''}}</td>
                                            <td class="text-left">
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-light btn-floating btn-icon btn-sm"
                                                       data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false">
                                                        <i class="fa fa-ellipsis-v" aria-hidden="true"></i>
                                                    </a>
                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item" href="{{ route('sales.edit',$sale) }}">ویرایش</a>
                                                        <form action="{{ route('sales.delete',$sale) }}" method="post"
                                                              id="delete-{{ $sale->id }}-Sale" class="d-none">
                                                            @csrf
                                                        </form>
                                                        <a class="dropdown-item"
                                                           onclick="return confirm('آیا مطمئن هستید؟') ? document.getElementById('delete-{{ $sale->id }}-Sale').submit() : ''"
                                                           href="#">حذف</a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                            {{ $sales->links('pagination::bootstrap-4') }}
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
    <script src="{{ asset('admin/assets/vendors/select2/js/select2.min.js') }}"></script>
    <!-- end::datepicker -->
    <script>
        $(document).ready(function () {
            $('.date').datepicker({
                dateFormat: 'yy/mm/dd',
            })
            $('#customer_id').select2({
                dir: 'rtl'
            });
        })
    </script>
    <script>
        function deleteSale() {
            document.getElementById('deleteSale').submit();
        }
        $('#customer').select2({
            rtl: true,
        })
        $('#pay_type').on('change', function (e) {
            if (e.target.value == "{{\App\Constants\SaleType::CASH}}") {
                $('#installment-count').addClass('d-none')
            } else {
                $('#installment-count').removeClass('d-none')
            }
        })
    </script>
@endpush

