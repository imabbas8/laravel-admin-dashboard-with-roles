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
<div class="row my-5">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">{{$title}}</h3>
            </div>
            <div class="card-body">

                @if(session('success'))
                    <div class="alert alert-success">{{session('success')}}</div>
                @endif

                 @if(session('error'))
                    <div class="alert alert-danger">{{session('error')}}</div>
                @endif
                <form class="form w-100" novalidate="novalidate"  action="{{route('admin.user-permission-update',$user->id)}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{request()->route('id')}}">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="fv-row mb-8">

                                <select disabled class="form-select @error('role') is-invalid @enderror" data-control="select2" data-placeholder="Select Role" name="role">
                                    <option>{{$user->name}} => {{$user->email}}</option>
                                </select>
                                @error('role')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        @foreach($permissions as $key => $permission)

                         @php
                            $search =  array_search($permission->name,$user_permissions);
                            if($search !== false){
                                $checked =  "checked";
                            }else{
                                 $checked =  "";
                            }
                        @endphp

                        
                       
                        <div class="col-md-6 my-2">
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" name="permissionCheckBox[]" type="checkbox" value="{{$permission->id}}" id="permissionCheck{{$permission->id}}" {{$checked}} />
                                <label class="form-check-label" for="permissionCheck{{$permission->id}}">
                                    @php
                                        $str = str_replace('admin.',"",$permission->name);
                                        $name = str_replace("-"," ",$str);
                                    @endphp
                                    {{ucWords($name)}}
                                </label>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <div class="row">

                         <div class="col-md-12 my-2">

                         <button type="submit" class="btn btn-primary float-end">Change Permission</button>
                         
                     </div>
                        
                    </div>


                  
                    
                    
                </form>
            </div>
        </div>
    </div>
</div>
@endsection