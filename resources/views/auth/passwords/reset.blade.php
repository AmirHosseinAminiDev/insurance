@extends('auth.layout.master')
@section('content')
    <div class="container h-100-vh">
        <div class="row align-items-center h-100-vh">
            <div class="col-lg-6 d-none d-lg-block p-t-b-25">
                <img class="img-fluid" src="{{ asset('admin/assets/media/svg/recover-password.svg') }}" alt="...">
            </div>
            <div class="col-lg-4 offset-lg-1 p-t-25 p-b-10">
                <h3>بازیابی رمز عبور</h3>
                <p>رمز عبور خود را هم اکنون تغییر دهید</p>
                <form method="post" action="{{ route('password.update') }}">
                    @csrf
                    <input type="hidden" name="token" value="{{ $token }}">
                    <div class="form-group mb-4">
                        <input type="hidden" name="email" value="{{ $email ?? old('email') }}"
                               class="form-control fodrm-control-lg @error('email') is-invalid @enderror" autofocus
                               placeholder="آدرس ایمیل">
                        @error('email')
                        <div class="alert alert-danger">
                            <strong class="text-white">
                                {{ $message }}
                            </strong>
                        </div>
                        @enderror
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="password"
                               class="form-control fodrm-control-lg @error('password') is-invalid @enderror" autofocus
                               placeholder="رمز عبور جدید">
                    </div>
                    <div class="form-group mb-4">
                        <input type="password" name="password_confirmation"
                               class="form-control fodrm-control-lg @error('password') is-invalid @enderror" autofocus
                               placeholder="تکرار رمز عبور جدید">
                        @error('email')
                        <div class="alert alert-danger">
                            <strong class="text-white">
                                {{ $message }}
                            </strong>
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4" type="submit">ثبت</button>
                </form>
            </div>
        </div>
    </div>
@endsection
