@extends('auth.layout.master')
@section('content')
    <div class="container h-100-vh">
        <div class="row align-items-center h-100-vh">
            <div class="col-lg-6 d-none d-lg-block p-t-b-25">
                <img class="img-fluid" src="{{ asset('admin/assets/media/svg/login.svg') }}" alt="...">
            </div>
            <div class="col-lg-4 offset-lg-1 p-t-b-25">
                <div class="d-flex align-items-center m-b-20">
                    <img src="{{ asset('logo.png') }}" class="m-l-15" width="350" alt="">
                </div>
                <p>برای ادامه وارد شوید.</p>
                <form action="{{ route('login') }}" method="post">
                    @csrf
                    <div class="form-group mb-4">
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control form-control-lg @error('email') is-invalid @enderror" id="email"
                               autofocus
                               placeholder="ایمیل">
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
                               class="form-control form-control-lg @error('password') is-invalid @enderror"
                               id="passowrd"
                               placeholder="رمز عبور">
                        @error('password')
                        <div class="alert alert-danger">
                            <strong class="text-white">
                                {{ $message }}
                            </strong>
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4">ورود</button>
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" name="remember"
                                   {{ old('remember') ? 'checked' : '' }} class="custom-control-input" id="remember">
                            <label class="custom-control-label" for="remember">به خاطر سپاری</label>
                        </div>
                        <a href="{{ route('password.request') }}" class="auth-link text-black">فراموشی رمز عبور؟</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
