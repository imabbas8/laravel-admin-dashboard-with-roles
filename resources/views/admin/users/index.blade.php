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
            // order: [[2, 'asc']],
            stateSave: true,
            select: {
                style: 'multi',
                selector: 'td:first-child input[type="checkbox"]',
                className: 'row-selected'
            },
            ajax: {
                url: "{{route('admin.user-list')}}",
            },
            columns: [
                { data: 'RecordID' },
                { data: 'name' },
                { data: 'username' },
                { data: 'email' },
                { data: function(data){


                    if(data.role =="super-admin"){
                            return `<span class="badge badge-light-success">${data.role}</span>`;
                        }else if(data.role =="admin"){
                            return `<span class="badge badge-light-info">${data.role}</span>`;
                        }else{
                            return `<span class="badge badge-light-primary">${data.role}</span>`;
                        }

                }, name:"role" },
                { data: function(data){
                    if(data.payment_status == null || data.payment_status == 0){
                         return `<span class="badge badge-light-warning">Pending</span>`;
                    }else if(data.payment_status == 1){
                         return `<span class="badge badge-light-warning">Active</span>`;
                    }else if(data.payment_status == 1){
                         return `<span class="badge badge-light-warning">Deactivate</span>`;
                    }
                } },
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
                    text: "Are you sure you want to "+type_status+" this record?",
                    icon: "warning",
                    showCancelButton: true,
                    buttonsStyling: false,
                    confirmButtonText: "Continue",
                    cancelButtonText: "No, cancel",
                    customClass: {
                        confirmButton: "btn fw-bold btn-danger",
                        cancelButton: "btn fw-bold btn-active-light-primary"
                    }
                }).then(function (result) {
                    if (result.value) {
                        // Simulate delete request -- for demo purpose only
                        Swal.fire({
                            text: "Processing",
                            icon: "info",
                            buttonsStyling: false,
                            showConfirmButton: false,
                            timer: 2000
                        }).then(function () {

                            $.ajax({
                                url:"{{route('admin.user-delete')}}",
                                type:"POST",
                                data:{_token,id,type_status},
                                success:function(response){
                                    // console.log(response);

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
                            text: "this recored was not "+type_status+".",
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
</script>
@endpush
@section('content')

<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
	
	<div class="col-xl-12">
		<div class="card card-flush overflow-hidden h-lg-100">
			<div class="card-body">
				<!--begin::Wrapper-->
<div class="d-flex flex-stack mb-5">
    <!--begin::Search-->
    <div class="d-flex align-items-center position-relative my-1">
        <i class="ki-duotone ki-magnifier fs-1 position-absolute ms-6"><span class="path1"></span><span class="path2"></span></i>
        <input type="text" data-kt-docs-table-filter="search" class="form-control form-control-solid w-250px ps-15" placeholder="Search"/>
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

<!--begin::Datatable-->
<table id="kt_datatable_example_1" class="table align-middle table-row-dashed fs-6 gy-5">
    <thead>
    <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
        <th class="w-10px pe-2">
           #
        </th>
        <th>Full Name</th>
        <th>User Name</th>
        <th>Email</th>
        <th>Role</th>
        <th>Payment Status</th>
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


@endsection