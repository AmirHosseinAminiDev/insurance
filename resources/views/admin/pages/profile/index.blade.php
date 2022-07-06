@extends('admin.layout.master')
@section('title') ویرایش پروفایل @endsection
@section('content')
    <!-- begin::main content -->
    <main class="main-content">
        <div class="row row-sm">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <h3>ویرایش اطلاعات کاربری</h3>
                        <form action="{{ route('profile.updateInfo') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">نام :</label>
                                <input type="text" name="name" id="name" value="{{ auth()->user()->name ?? old('name') }}" class="form-control @error('name') is-invalid @enderror" placeholder="نام خود را وارد کنید">
                                <div>
                                    @error('name')
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="email">ایمیل :</label>
                                <input type="email" name="email" id="email" value="{{ auth()->user()->email ?? old('email') }}" class="form-control @error('email') is-invalid @enderror" placeholder="ایمیل خود را وارد کنید">
                                @error('email')
                                <strong class="text-danger">
                                    {{ $message }}
                                </strong>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-success" onclick="return confirm('آیا مطمئن هستید؟')">ویرایش</button>
                        </form>
                    </div>
                </div>
                <div class="card">
                    @if($errors->any())
                        <ul class="bg-danger">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="card-body">
                        <h3>ویرایش رمز عبور</h3>
                        <form action="{{ route('profile.updatePassowrd') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="current_password">رمز عبور فعلی :</label>
                                <input type="password" name="current_password" id="current_password"  class="form-control" placeholder="رمز عبور فعلی خود را وارد کنید">
                                <div>
                                    @error('current_password')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="password">رمز عبور جدید :</label>
                                <input type="password" name="password" id="password"  class="form-control" placeholder="رمز عبور جدید را وارد کنید">
                                <div>
                                    @error('password')
                                    <strong class="text-danger">
                                        {{ $message }}
                                    </strong>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">تکرار رمز عبور جدید :</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="رمز عبور جدید خود را مجدد وارد کنید">
                                <div>
                                    @error('password_confirmation')
                                        <strong class="text-danger">
                                            {{ $message }}
                                        </strong>
                                    @enderror
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success" onclick="return confirm('آیا مطمئن هستید؟')">ویرایش</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6 class="card-title d-flex justify-content-between align-items-center">
                            اطلاعات
                            <a href="#name" class="link-1 font-size-13 primary-font">
                                <i class="ti-pencil m-r-5 align-middle"></i> ویرایش
                            </a>
                        </h6>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">نام:</div>
                            <div class="col-6">{{ auth()->user()->name }}</div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-6 text-muted">ایمیل:</div>
                            <div class="col-6">{{ auth()->user()->email }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </main>
    <!-- end::main content -->
@endsection
