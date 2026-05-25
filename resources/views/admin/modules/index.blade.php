@extends('admin.partisal.master')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
	<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
		
		<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
			
			<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Modules</h1>
			
			<ul class="breadcrumb breadcrumb-separatorless fw-semibold fs-7 my-0 pt-1">
				
				<li class="breadcrumb-item text-muted">
					<a href="{{route('admin.dashboard')}}" class="text-muted text-hover-primary">Home</a>
				</li>
				<li class="breadcrumb-item">
					<span class="bullet bg-gray-400 w-5px h-2px"></span>
				</li>
				<li class="breadcrumb-item text-muted">Modules</li>
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

	
	<div class="col-xl-6">
		<div class="card card-flush overflow-hidden h-lg-100">


			<div class="card-header">
                <h3 class="card-title">All Permissions</h3>
            </div>
			<div class="card-body">

            <div class="row my-5" >
               @foreach($permissions as $key => $permission)

                        

                        
                       
                        <div class="col-md-6 my-2">
                            <div class="form-check form-check-custom form-check-solid">
                                <input checked class="form-check-input" name="permissionCheckBox[]" type="checkbox" value="{{$permission->id}}" id="permissionCheck{{$permission->id}}"  />
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
		</div>
	</div>

    
	<div class="col-xl-6">

    	
		<div class="card card-flush overflow-hidden h-lg-100">
<div class="card-header">
                <h3 class="card-title">All Modules</h3>
            </div>

			<div class="card-body">
            
              <div class="row my-5" >
               @foreach($modules as $key => $module)

                        

                        
                       
                        <div class="col-md-6 my-2">
                            <div class="form-check form-check-custom form-check-solid">
                                <input checked class="form-check-input" name="permissionCheckBox[]" type="checkbox" value="{{$module->id}}" id="permissionCheck{{$module->id}}"  />
                                <label class="form-check-label" for="permissionCheck{{$module->id}}">
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
		</div>
	</div>
</div>



@endsection