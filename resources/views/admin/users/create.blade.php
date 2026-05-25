@extends('admin.partisal.master')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{$title}}</h1>
            
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                
                <li class="breadcrumb-item text-muted">
                    <a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">{{$title}}</li>
            </ul>
        </div>
        
    </div>
    
</div>
@endsection
@push('scripts')
<script src="{{url('assets/js/custom/authentication/sign-in/general.js')}}"></script>
@endpush
@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-body">
                <form class="form w-100" novalidate="novalidate"  action="{{ route('admin.user-store') }}" method="POST">
    @csrf
    
    <div class="text-center mb-11">
        <h1 class="text-dark fw-bolder mb-3" style="margin-top: 2rem;">{{$title}}</h1>
    </div>
     @if(session('success'))

                <div class="alert alert-success d-flex align-items-center p-5" >
                    <i class="ki-duotone ki-shield-tick fs-2hx text-success me-4"><span class="path1"></span><span class="path2"></span></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">{{session('success')}}</h4>
                        
                    </div>   
                </div>
            @elseif(session('error'))

            <div class="alert alert-danger d-flex align-items-center p-5" >
                    <i class="ki-duotone ki-shield-tick fs-2hx text-danger me-4"><span class="path1"></span><span class="path2"></span></i>
                    <div class="d-flex flex-column">
                        <h4 class="mb-1 text-dark">{{session('error')}}</h4>
                        
                    </div>   
                </div>

        @endif
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
                <input  placeholder="Repeat Password" name="password_confirmation" type="password" autocomplete="off" class="form-control bg-transparent " />
                @error('password_confirmation')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>

        <div class="col-md-12">
            <div class="fv-row mb-8">

                <select class="form-select @error('role') is-invalid @enderror" data-control="select2" data-placeholder="Select Role" name="role">
                    <option></option>
                    @foreach($roles as $role)
                        @php
                            $name = str_replace('-'," ",$role->name);
                        @endphp
                        <option value="{{$role->id}}">
                            {{ucWords($name)}}
                        </option>
                    @endforeach
                </select>

                @error('role')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    
    
    
    <div class="d-grid mb-10">
        <button type="submit" id="kt_sign_up_submit" class="btn btn-primary">
        <span class="indicator-label">Create Account</span>
        <span class="indicator-progress">Please wait...
            <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
            </button>
        </div>
      
        </form>
            </div>
        </div>
    </div>
</div>

 @endsection