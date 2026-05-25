@extends('admin.partisal.master')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
    <div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
        
        <div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
            
            <h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">{{$title}}</h1>
            
            <ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
                
                <li class="breadcrumb-item text-muted">
                    <a href="../../demo1/dist/index.html" class="text-muted text-hover-primary">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <span class="bullet bg-gray-400 w-5px h-2px"></span>
                </li>
                <li class="breadcrumb-item text-muted">Dashboards</li>
            </ul>
        </div>
        
    </div>
    
</div>
@endsection
@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    @foreach($users as $user)
    <div class="col-xl-4">
       <div class="card card-flush h-md-100">
                <!--begin::Card header-->
                <div class="card-header">
                    <!--begin::Card title-->
                    <div class="card-title">
                        <h2>{{$user->roles[0]->name}}</h2>

                    </div>
                    <!--end::Card title-->
                </div>
                <!--end::Card header-->
                <!--begin::Card body-->
                <div class="card-body pt-1">
                    <!--begin::Users-->
                    <div class="fw-bold text-gray-600 mb-5">{{$user->email}}</div>
                    <!--end::Users-->
                    <!--begin::Permissions-->
                    <div class="d-flex flex-column text-gray-600">
                                                    <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Create payroll</div>
                                                    <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Read repository management</div>
                                                    <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Create database management</div>
                                                    <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Read api controls</div>
                                                    <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>Create user management</div>
                                                                            <div class="d-flex align-items-center py-2">
                                <span class="bullet bg-primary me-3"></span>
                                <em>and 22 more...</em>
                            </div>
                                                                    </div>
                    <!--end::Permissions-->
                </div>
                <!--end::Card body-->
                <!--begin::Card footer-->
                <div class="card-footer flex-wrap pt-0">
                    <a href="http://127.0.0.1:8000/user-management/roles/1" class="btn btn-light btn-active-primary my-1 me-2">View Role</a>
                    <button type="button" class="btn btn-light btn-active-light-primary my-1" data-role-id="administrator" data-bs-toggle="modal" data-bs-target="#kt_modal_update_role">Edit Role</button>
                </div>
                <!--end::Card footer-->
            </div>
    </div>
    @endforeach
</div>
@endsection