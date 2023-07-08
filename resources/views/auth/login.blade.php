@extends('layouts.app')

@section('content')
    <!--begin::Main-->
    <div class="d-flex flex-column flex-root">
        <!--begin::Login-->
        <div class="login login-5 login-signin-on d-flex flex-row-fluid " id="kt_login">
            <div class="d-flex flex-center bgi-size-cover bgi-no-repeat flex-row-fluid col-12 "
                style="background-image: url({{ asset('admin-assets/media/bg.jpg') }});">
                <div class="login-form text-center text-white p-7 position-relative overflow-hidden col-12 row ">
                    <!--begin::Login Header-->
                    <div class="login-signin offset-md-4 offset-sm-0 offset-0 col-md-4 col-12  text-center">
                        <div class="mb-20">
                            <h3 class="opacity-40 font-weight-normal">{{ __('Login') }} </h3>
                            <p class="opacity-40">Enter your details to login</p>
                        </div>
                        <form class="form" id="kt_login_signin_form" action="{{ route('login') }}" method="POST">
                            @csrf
                            <div class="form-group mx-20">
                                <input
                                    class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8  @error('email') is-invalid @enderror"
                                    type="email" placeholder="Email" name="email" value="{{ old('email') }}" required
                                    autofocus autocomplete="off" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mx-20">
                                <input
                                    class="form-control h-auto text-white bg-white-o-5 rounded-pill border-0 py-4 px-8  @error('password') is-invalid @enderror"
                                    type="password" required placeholder="Password" name="password"
                                    autocomplete="current-password" />
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                            <div class="form-group mx-20">
                                <div class="checkbox-inline">
                                    <label class="checkbox checkbox-outline checkbox-white text-white m-0 ">
                                        <input type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }} />
                                        <span></span> {{ __('Remember Me') }}
                                    </label>
                                </div>
                            </div>

                            @if (!request()->hasCookie('blocked_time') && @$user->blocked_time < Carbon\Carbon::now())
                                <div class="form-group text-center mt-10 mx-20" id="loginBtn">
                                    <button id="kt_login_signin_submit"
                                        class="btn btn-pill btn-primary opacity-90 px-15 py-3 text-black">Sign In</button>
                                </div>
                            @else
                                <div id="countdown"> {{ request()->Cookie('blocked_time') }} </div>
                                <div id="showBtn">

                                </div>
                            @endif
                        </form>
                    </div>
                    <!--end::Login Sign in form-->
                </div>
            </div>
        </div>
        <!--end::Login-->
    </div>
    <!--end::Main-->
@endsection

@section('js')
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script>
        @if (session()->has('error'))
            Swal.fire("error", "{{ session()->get('error') }}", "error");
        @endif
    </script>

    <script>
        @if (request()->hasCookie('blocked_time') &&  request()->Cookie('blocked_time')== 'you have to wait for 30 seconds' )

            var countdownTime = 30;

            function updateCountdown() {
                var countdownElement = document.getElementById('countdown');
                if (countdownTime > 0) {
                    countdownElement.innerHTML = 'You have to wait for ' + countdownTime + ' seconds';
                    countdownTime--;
                    setTimeout(updateCountdown, 1000);
                } else {
                    var btnElement = document.getElementById('showBtn');
                    btnElement.innerHTML =
                        '<div class="form-group text-center mt-10 mx-20"><button id="kt_login_signin_submit" class="btn btn-pill btn-primary opacity-90 px-15 py-3 text-black">Sign In</button> </div>';
                    countdownElement.style.display = 'none';
                }
            }
            updateCountdown();
        @endif

        // Start the countdown
    </script>
@endsection
