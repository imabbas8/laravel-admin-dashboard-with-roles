@extends('layouts.master')
@push('scripts')
<script src="{{url('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endpush
@section('content')
<form class="form w-100" novalidate="novalidate"  data-kt-redirect-url="{{route('admin.dashboard')}}" action="{{route('login')}}" method="POST">
    @csrf
    <div class="text-center mb-11">
        <a href="{{route('login')}}" class="mb-10">
            <img alt="Logo" src="{{url('assets/logos/navlogo.png')}}" width="100" />
        </a>
        <h1 class="text-dark fw-bolder mb-3">Sign In</h1>
        <div class="text-gray-500 fw-semibold fs-6">Your Social Campaigns</div>
    </div>
    @if(session('error'))
    <div class="alert alert-danger">{{session('error')}}</div>
    @endif
    <div class="fv-row mb-8">
        <input type="text" placeholder="Username / Or Email" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid @enderror" />
        @error('email')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="fv-row mb-3">
        <input type="password" placeholder="Password" name="password" autocomplete="off" class="form-control bg-transparent @error('password') is-invalid @enderror" />
        @error('password')
        <span class="invalid-feedback" role="alert">
            <strong>{{ $message }}</strong>
        </span>
        @enderror
    </div>
    <div class="d-flex flex-stack flex-wrap gap-3 fs-base fw-semibold mb-8">
        <div></div>
        <a href="{{route('password.request')}}" class="link-primary">Forgot Password ?</a>
    </div>
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_in_submit" class="btn btn-primary">
        <span class="indicator-label">Sign In</span>
        <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <div class="text-gray-500 text-center fw-semibold fs-6">Not a Member yet?
            <a href="{{route('register')}}" class="link-primary">Sign up</a></div>
        </form>
        @endsection