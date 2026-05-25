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
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-wrap flex-sm-nowrap">
                    <!--begin: Pic-->
                    <div class="me-7 mb-4">
                        <div class="symbol symbol-100px symbol-lg-160px symbol-fixed position-relative">
                            <img src="{{url('assets/media/avatars/300-1.jpg')}}" alt="image" />
                            <div class="position-absolute translate-middle bottom-0 start-100 mb-6 bg-success rounded-circle border border-4 border-body h-20px w-20px"></div>
                        </div>
                    </div>
                    <!--end::Pic-->
                    <!--begin::Info-->
                    <div class="flex-grow-1">
                        <!--begin::Title-->
                        <div class="d-flex justify-content-between align-items-start flex-wrap mb-2">
                            <!--begin::User-->
                            <div class="d-flex flex-column">
                                <!--begin::Name-->
                                <div class="d-flex align-items-center mb-2">
                                    <a href="#" class="text-gray-900 text-hover-primary fs-2 fw-bold me-1">{{ucfirst($authUser->name)}}</a>
                                    <a href="#">
                                        <i class="ki-duotone ki-verify fs-1 text-primary">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        </i>
                                    </a>
                                </div>
                                <!--end::Name-->
                                <!--begin::Info-->
                                <div class="d-flex flex-wrap fw-semibold fs-6 mb-4 pe-2">
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary me-5 mb-2">
                                        <i class="ki-duotone ki-profile-circle fs-4 me-1">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                        <span class="path3"></span>
                                    </i>{{ucfirst($authUser->roles[0]->name)}}</a>
                                    <a href="#" class="d-flex align-items-center text-gray-400 text-hover-primary mb-2">
                                        <i class="ki-duotone ki-sms fs-4">
                                        <span class="path1"></span>
                                        <span class="path2"></span>
                                    </i>{{ucfirst($authUser->email)}}</a>
                                </div>
                                <!--end::Info-->
                            </div>
                            <!--end::User-->
                        </div>
                        <!--end::Details-->
                        <!--begin::Navs-->
                        <ul class="nav nav-stretch nav-line-tabs nav-line-tabs-2x border-transparent fs-5 fw-bold">
                            <!--begin::Nav item-->
                            @can('admin.user-edit')
                                <li class="nav-item mt-2">
                                    <a class="nav-link text-active-primary ms-0 me-10 py-5  @if(request()->route()->getName()  == 'admin.profile-setting') active @endif" href="{{route('admin.profile-setting')}}">Update Profile</a>
                                </li>
                            @endcan
                            @can('admin.password-change')
                            <li class="nav-item mt-2">
                                <a class="nav-link text-active-primary ms-0 me-10 py-5 @if(request()->route()->getName()  == 'admin.password-change') active @endif" href="{{route('admin.password-change')}}">Change Password</a>
                            </li>
                            @endcan
                        </ul>
                        <!--begin::Navs-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row my-5 ">
    <div class="col-md-12">
        @if(session('success'))
            <div class="alert alert-success">{{session('success')}}</div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">{{session('error')}}</div>
        @endif
        
     </div>
</div>
<div class="row my-5 @if(request()->route()->getName()  != 'admin.profile-setting') d-none @endif">
    <div class="col-md-12">
        <form action="{{route('admin.profile-update')}}" method="POST">
            @csrf
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Profile Details</h3>
                    </div>
                </div>
                <div class="card-body p-9">
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Full Name</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$authUser->name}}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>

                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Username</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control @error('username') is-invalid @enderror" name="username" value="{{$authUser->username}}">

                            @error('username')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                    </div>

                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">E-mail</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control @error('email') is-invalid @enderror" name="email" value="{{$authUser->email}}">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                    </div>
                    <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Company</label>
                        <div class="col-lg-8 fv-row">
                            <span class="fw-semibold text-gray-800 fs-6">
                                <input type="text" class="form-control @error('organization') is-invalid @enderror" name="organization" value="{{$authUser->organization->name}}"   @role('user') disabled @endrole>

                                  @error('organization')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </span>
                        </div>
                    </div>
                    <div class="row mb-7">
                        <!--begin::Label-->
                        <label class="col-lg-4 fw-semibold text-muted">Role</label>
                        <!--end::Label-->
                        <!--begin::Col-->
                        <div class="col-lg-8">
                           <select @role('user') disabled @endrole class="form-select @error('role') is-invalid @enderror" data-control="select2" data-placeholder="Select Role" name="role">
                                <option></option>
                                @foreach($roles as $role)

                                    @php
                                        $name = str_replace('-'," ",$role->name);
                                    @endphp
                                    <option value="{{$role->id}}" @if($role->name == $authUser->roles[0]->name) selected @endif>
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
                        <!--end::Col-->
                    </div>
                </div>
                <!--end::Card body-->
            </div>

            <div class="row my-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary float-end">Update Profile</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="row my-5 @if(request()->route()->getName()  != 'admin.password-change') d-none @endif">
    <div class="col-md-12">
        <form action="{{route('admin.password-update')}}" method="POST">
            @csrf
            <div class="card mb-5 mb-xl-10" id="kt_profile_details_view">
                <div class="card-header cursor-pointer">
                    <div class="card-title m-0">
                        <h3 class="fw-bold m-0">Change Password</h3>
                    </div>
                </div>
                <div class="card-body p-9">

                      <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">New Password</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control  @error('password') is-invalid  @enderror" name="password" >

                             @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror

                        </div>
                    </div>
                      <div class="row mb-7">
                        <label class="col-lg-4 fw-semibold text-muted">Confirm Password</label>
                        <div class="col-lg-8">
                            <input type="text" class="form-control @error('confirm_password') is-invalid  @enderror" name="confirm_password" >

                            @error('confirm_password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                        </div>
                    </div>

                </div>
            </div>


              <div class="row my-5">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <button type="submit" class="btn btn-primary float-end">Update Password</button>
                        </div>
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection