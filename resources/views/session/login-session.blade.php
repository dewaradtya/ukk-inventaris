@extends('layouts.user_type.guest')

@section('content')
    <main class="main-content mt-0">
        <section>
            <div class="page-header min-vh-75">
                <div class="container">
                    <div class="row">
                        <div class="col-xl-4 col-lg-5 col-md-6 d-flex flex-column mx-auto">
                            <div class="card card-plain mt-8">
                                <div class="card-header pb-0 text-left bg-transparent">
                                    <h3 class="font-weight-bolder text-info text-gradient">Welcome to Back!</h3>
                                    <p class="mb-0">
                                        Don't have an account?
                                        <a href="register" class="text-info text-gradient font-weight-bold">Sign up</a>
                                    </p>
                                </div>
                                <div class="card-body">
                                    <form role="form" method="POST" action="/session">
                                        @csrf
                                        <label>Email</label>
                                        <div class="mb-3">
                                            <input type="email" class="form-control" name="email" id="email"
                                                placeholder="Email" aria-label="Email" aria-describedby="email-addon">
                                            @error('email')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <label>Password</label>
                                        <div class="mb-3">
                                            <input type="password" class="form-control" name="password" id="password"
                                                placeholder="Password" aria-label="Password"
                                                aria-describedby="password-addon">
                                            @error('password')
                                                <p class="text-danger text-xs mt-2">{{ $message }}</p>
                                            @enderror
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" id="rememberMe" checked>
                                                <label class="form-check-label" for="rememberMe">Remember me</label>
                                            </div>
                                            <a href="/login/forgot-password" class="text-info">Forgot password?</a>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn bg-gradient-info w-100 mt-4 mb-0">Sign
                                                in</button>
                                        </div>
                                    </form>
                                </div>

                                <div class="card-footer text-center pt-0 px-lg-2 px-1">
                                    <div class="row px-xl-5 px-sm-4 px-3">
                                        <div class="mb-3 position-relative text-center">
                                            <p
                                                class="text-sm font-weight-bold text-secondary d-inline bg-white px-3 position-relative z-1">
                                                or</p>
                                        </div>
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;" href="javascript:;">
                                                <i class="fa-brands fa-facebook fa-2x text-info"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;" href="javascript:;">
                                                <i class="fa-brands fa-apple fa-2x text-dark"></i>
                                            </a>
                                            <a class="btn btn-outline-secondary d-flex align-items-center justify-content-center"
                                                style="width: 50px; height: 50px;" href="{{ route('google.login') }}">
                                                <i class="fa-brands fa-google fa-2x text-danger"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="oblique position-absolute top-0 h-100 d-md-block d-none me-n8">
                                <div class="oblique-image bg-cover position-absolute fixed-top ms-auto h-100 z-index-0 ms-n6"
                                    style="background-image:url('../assets/img/curved-images/curved6.jpg')"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@endsection
