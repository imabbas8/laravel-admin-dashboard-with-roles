@extends('admin.partisal.master')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
	<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
		
		<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
			
			<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Roles</h1>
			
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
				
				<li class="breadcrumb-item text-muted">
					<a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
				</li>
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-400 w-5px h-2px"></span>
				</li>
				<li class="breadcrumb-item text-muted">Roles</li>
			</ul>
		</div>
		
	</div>
	
</div>
@endsection
@push('css')
<link href="{{url('assets/plugins/custom/datatables/datatables.bundle.css')}}" rel="stylesheet" type="text/css"/>

@endpush
@push('scripts')

	<script src="{{url('assets/plugins/custom/datatables/datatables.bundle.js')}}"></script>
@endpush
@push('scripts')
<script type="text/javascript">
	"use strict";

// Class definition
var KTDatatablesServerSide = function () {
    // Shared variables
    var table;
    var dt;
    var filterPayment;

    // Private functions
    var initDatatable = function () {
        dt = $("#kt_datatable_example_1").DataTable({
            searchDelay: 500,
            processing: true,
            serverSide: true,
            order: [[2, 'desc']],
            stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: "{{route('admin.role-list')}}",
            },
            columns: [
                { data: 'RecordID' },
                { data: 'name' },
                { data: 'created_at' },
                { data: null },
            ],
            columnDefs: [
                {
                    targets: 0,
                    orderable: false,
                    render: function (data,type,meta,row) {
                        // console.log(row);
                        return row.row + 1;
                        // return `
                        //     <div class="form-check form-check-sm form-check-custom form-check-solid">
                        //         <input class="form-check-input" type="checkbox" value="${data}" />
                        //     </div>`;
                    }
                },
                {
                    targets: -1,
                    data: null,
                    orderable: false,
                    className: 'text-end',
                    render: function (data, type, row) {
                        
                        return data.action;
                    },
                },
            ],
           
        });

        table = dt.$;

        // Re-init functions on every table re-draw -- more info: https://datatables.net/reference/event/draw
        dt.on('draw', function () {
            initToggleToolbar();
            toggleToolbars();
            handleDeleteRows();
            KTMenu.createInstances();
        });
    }

    // Search Datatable --- official docs reference: https://datatables.net/reference/api/search()
    var handleSearchDatatable = function () {
        const filterSearch = document.querySelector('[data-kt-docs-table-filter="search"]');
        filterSearch.addEventListener('keyup', function (e) {
            dt.search(e.target.value).draw();
        });
    }
    var handleDeleteRows = () => {
        // Select all delete buttons
        const deleteButtons = document.querySelectorAll('[data-kt-docs-table-filter="delete_row"]');

        deleteButtons.forEach(d => {
            // Delete button on click
            d.addEventListener('click', function (e) {
                e.preventDefault();

                // Select parent row
                const parent = e.target.closest('tr');

                // Get customer name
                const customerName = parent.querySelectorAll('td')[1].innerText;

                 var id = e.target.getAttribute('data-id')
                var type_status = e.target.getAttribute('data-type_status')
                var _token = "{{csrf_token()}}"


                // SweetAlert2 pop up --- official docs reference: https://sweetalert2.github.io/
                Swal.fire({
                    text: "Are you sure you want to delete " + type_status + "?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Yes, delete!",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        // Simulate delete request -- for demo purpose only
                        Swal.fire({
                            text: "Deleting " + type_status,
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {
                            $.ajax({
                                url:"{{route('admin.role-delete')}}",
                                type:"POST",
                                data:{_token,id,type_status},
                                success:function(response){
                                    console.log(response);

                                    Swal.fire({
                                        text: "You have "+type_status+" successfully",
                                        icon: "success",
                                        buttonsStyling: false,
                                        confirmButtonText: "Ok, got it!",
                                        customClass: {
                                            confirmButton: "btn fw-bold btn-primary",
                                        }
                                    }).then(function () {
                                        // delete row data from server and re-draw datatable
                                        dt.draw();
                                    });
                                }
                            })
                        });
                    } else if (result.dismiss === 'cancel') {
                        Swal.fire({
                            text: customerName + " was not deleted.",
                            icon: "error",
                            buttonsStyling: false,
                            confirmButtonText: "Ok, got it!",
                            customClass: {
                                confirmButton: "btn fw-bold btn-primary",
                            }
                        });
                    }
                });
            })
        });
    }

    // Reset Filter
    var handleResetForm = () => {
        const resetButton = document.querySelector('[data-kt-docs-table-filter="reset"]');
            dt.search('').draw();
    }

    // Init toggle toolbar
    var initToggleToolbar = function () {
        // Toggle selected action toolbar
        // Select all checkboxes
        const container = document.querySelector('#kt_datatable_example_1');
        const checkboxes = container.querySelectorAll('[type="checkbox"]');

        // Select elements
        const deleteSelected = document.querySelector('[data-kt-docs-table-select="delete_selected"]');

        // Toggle delete selected toolbar
        checkboxes.forEach(c => {
            // Checkbox on click event
            c.addEventListener('click', function () {
                setTimeout(function () {
                    toggleToolbars();
                }, 50);
            });
        });

       
    }

    // Toggle toolbars
    var toggleToolbars = function () {
        // Define variables
        const container = document.querySelector('#kt_datatable_example_1');
        const toolbarSelected = document.querySelector('[data-kt-docs-table-toolbar="selected"]');
        const selectedCount = document.querySelector('[data-kt-docs-table-select="selected_count"]');

        // Select refreshed checkbox DOM elements
        const allCheckboxes = container.querySelectorAll('tbody [type="checkbox"]');

        // Detect checkboxes state & count
        let checkedState = false;
        let count = 0;

        // Count checked boxes
        allCheckboxes.forEach(c => {
            if (c.checked) {
                checkedState = true;
                count++;
            }
        });

        // Toggle toolbars
        if (checkedState) {
            selectedCount.innerHTML = count;
            toolbarSelected.classList.remove('d-none');
        } else {
            toolbarSelected.classList.add('d-none');
        }
    }

    // Public methods
    return {
        init: function () {
            initDatatable();
            handleSearchDatatable();
            initToggleToolbar();
            handleDeleteRows();
            handleResetForm();
        }
    }
}();

// On document ready
KTUtil.onDOMContentLoaded(function () {
    KTDatatablesServerSide.init();
});

function editRole(obj){
    var id = obj.getAttribute('data-id');
    var url = "{{url('admin/role/edit/')}}/"+id;
    $.ajax({
        url:url,
        method:"GET",
        dataType:"json",
        success:function(response){

            // console.log(response)
        
            var role_id = response.role.id;
            var role_name = response.role.name;
            $('#role_id').val(role_id);
            $('#role_name').val(role_name);

            var permissions = response.permissions;
            var permission_div = $('#permission_div');
            permission_div.empty();

            $.each(permissions, function(index, permission) {


                console.log();
                // console.log(permission.id);
                var checkbox = "";
                if(response.role_has_permissions.includes(permission.id) == true){
                    checkbox = "checked"
                }
               


                var str = permission.name.replace('admin.',"");
                var name = str.replace("-"," ");

                var permission_div = $('<div class="col-md-6 my-2"></div>');
                var form_check = $('<div class="form-check form-check-custom form-check-solid"></div>');
                var form_check_input = $('<input class="form-check-input" name="permissionCheckBoxs[]" type="checkbox" '+checkbox+'  value="' + permission.id + '" id="permissionCheck_'+ permission.id + '" />');
                var form_check_label = $('<label class="form-check-label" for="permissionCheck_' + permission.id + '">' + name.charAt(0).toUpperCase() + name.slice(1) + '</label>');
                form_check.append(form_check_input);
                form_check.append(form_check_label);
                permission_div.append(form_check);
                $('#permission_div').append(permission_div);
            });

            $('#EditRoleModal').modal('show')
            
        }
    })
}
</script>
@endpush
@section('content')

<div class="row g-5 g-xl-10 mb-5 mb-xl-10">

	
	<div class="col-xl-12">
		<div class="card card-flush overflow-hidden h-lg-100">

 

			<div class="card-body">

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

				<!--begin::Wrapper-->
<div class="d-flex flex-stack mb-5">
    <!--begin::Search-->
    <div class="d-flex align-items-center position-relative my-1">
        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
        <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search Roles"/>
    </div>
    <!--end::Search-->


    <!--begin::Group actions-->

    <div id="kt_datatable_example_buttons" class="d-none"></div>

  

    <div class="d-flex justify-content-end align-items-center d-none" data-kt-docs-table-toolbar="selected">
        <div class="fw-bold me-5">
            <span class="me-2" data-kt-docs-table-select="selected_count"></span> Selected
        </div>

        <button type="button" class="btn btn-danger" data-bs-toggle="tooltip" title="Coming Soon">
            Selection Action
        </button>
    </div>

   
    <!--end::Group actions-->
</div>

<!--end::Wrapper-->

  <button type="button" class="btn btn-primary " data-bs-toggle="modal" data-bs-target="#AddRoleModal">
        Add Role <i class="ki-duotone ki-plus"></i>
    </button>
    





<!--begin::Datatable-->
<table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
    <thead>
    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
        <!-- <th class="w-10px pe-2">
            <div class="form-check form-check-sm form-check-custom form-check-solid me-3">
                <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_datatable_example_1 .form-check-input" value="1"/>
            </div>
        </th> -->
        <th>#</th>
        <th>Role Name</th>
        <th>Created Date</th>
        <th class="text-end min-w-100px">Actions</th>
    </tr>
    </thead>
    <tbody class="text-gray-600 fw-semibold">
    </tbody>
</table>
<!--end::Datatable-->
			</div>
		</div>
	</div>
</div>

 <form action="{{route('admin.role-create')}}    " method="POST">
    @csrf
<div class="modal fade" tabindex="-1" id="AddRoleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Add Role</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
              
                    <input type="text" name="name" placeholder="Role Name" class="form-control">

                     <div class="row my-5" >
                        @foreach($permissions as $key => $permission)

                        

                        
                       
                        <div class="col-md-6 my-2">
                            <div class="form-check form-check-custom form-check-solid">
                                <input class="form-check-input" name="permissionCheckBox[]" type="checkbox" value="{{$permission->id}}" id="permissionCheck{{$permission->id}}"  />
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
                  
               
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>


<form action="{{route('admin.role-update')}}    " method="POST">
    @csrf
<div class="modal fade" tabindex="-1" id="EditRoleModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title">Edit Role</h3>

                <!--begin::Close-->
                <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                    <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                </div>
                <!--end::Close-->
            </div>

            <div class="modal-body">
                    <input type="hidden" name="id" id="role_id">
                    <input type="text" name="name" id="role_name" placeholder="Role Name" class="form-control">


                     <div class="row my-5" id="permission_div">
                        
                    </div>
                    
                  
               
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>
</form>



@endsection