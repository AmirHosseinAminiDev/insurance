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
                <form method="post" action="{{ route('password.email') }}">
                    @csrf
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="form-group mb-4">
                        <input type="email" name="email" value="{{ old('email') }}"
                               class="form-control form-control-lg @error('email') is-invalid @enderror" autofocus
                               placeholder="آدرس ایمیل">
                        @error('email')
                        <div class="alert alert-danger">
                            <strong class="text-white">
                                {{ $message }}
                            </strong>
                        </div>
                        @enderror
                    </div>
                    <button class="btn btn-primary btn-lg btn-block btn-uppercase mb-4" type="submit">ثبت</button>
                    <p class="text-left">
                        <a href="{{ route('login') }}" class="text-underline">حالا وارد شوید</a>
                    </p>
                </form>
            </div>
        </div>
    </div>
@endsection
