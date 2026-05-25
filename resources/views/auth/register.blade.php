@extends('layouts.master')
@push('scripts')
<script src="{{url('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endpush
@section('content')
<form class="form w-100" novalidate="novalidate" id="kt_sign_up_form" data-kt-redirect-url="{{route('admin.dashboard')}}" action="{{ route('register') }}" method="POST">
    @csrf
    
    <div class="text-center mb-11">
        <a href="{{route('register')}}" class="mb-10">
            <img alt="Logo" src="{{url('assets/logos/navlogo.png')}}" width="100" />
        </a>
        <h1 class="text-dark fw-bolder mb-3" style="margin-top: 2rem;">Sign Up</h1>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="fv-row mb-8">
                <input type="text" placeholder="Name" name="name" autocomplete="off" class="form-control bg-transparent @error('name') is-invalid @enderror" value="{{ old('name') }}"  />
                @error('name')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="fv-row mb-8">
                <input type="text" placeholder="User name" name="username" autocomplete="off" class="form-control bg-transparent @error('username') is-invalid @enderror" value="{{ old('username') }}"  />
                @error('username')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-12">
            <div class="fv-row mb-8">
                <input type="text" placeholder="Email" name="email" autocomplete="off" class="form-control bg-transparent @error('email') is-invalid @enderror" value="{{ old('email') }}" />
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-md-6">
            <div class="fv-row mb-8" data-kt-password-meter="true">
                <div class="mb-1">
                    <div class="position-relative mb-3">
                        <input class="form-control bg-transparent @error('password') is-invalid @enderror" type="password" placeholder="Password" name="password" autocomplete="off" />
                        <span class="btn btn-sm btn-icon position-absolute translate-middle top-50 end-0 me-n2" data-kt-password-meter-control="visibility">
                            <i class="ki-duotone ki-eye-slash fs-2"></i>
                            <i class="ki-duotone ki-eye fs-2 d-none"></i>
                        </span>
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="d-flex align-items-center mb-3" data-kt-password-meter-control="highlight">
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px me-2"></div>
                        <div class="flex-grow-1 bg-secondary bg-active-success rounded h-5px"></div>
                    </div>
                </div>
                <div class="text-muted">Use 8 or more characters with a mix of letters, numbers & symbols.</div>
            </div>
        </div>
        <div class="col-md-6">
            
            <div class="fv-row mb-8">
                <input placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent" />
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        
    </div>
    
    
    
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
        <span class="indicator-label">Sign up</span>
        <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
        <div class="text-gray-500 text-center fw-semibold fs-6">Already have an Account?
            <a href="{{route('login')}}" class="link-primary fw-semibold">Sign in</a></div>
        </form>
        @endsection