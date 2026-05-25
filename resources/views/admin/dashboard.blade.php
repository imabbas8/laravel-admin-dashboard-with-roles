@extends('admin.partisal.master')
@section('breadcrumb')
<div id="kt_app_toolbar" class="app-toolbar py-3 py-lg-6">
	<div id="kt_app_toolbar_container" class="app-container container-fluid d-flex flex-stack">
		
		<div class="page-title d-flex flex-column justify-content-center flex-wrap me-3">
			
			<h1 class="page-heading d-flex text-dark fw-bold fs-3 flex-column justify-content-center my-0">Multipurpose</h1>
			
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
@push('scripts')

	<script src="{{url('assets/js/widgets.bundle.js')}}"></script>
	<script src="{{url('assets/js/custom/widgets.js')}}"></script>
	<script src="{{url('assets/js/custom/apps/chat/chat.js')}}"></script>
@endpush
@section('content')

<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
	
	<div class="col-xl-12">
		<div class="card card-flush overflow-hidden h-lg-100">
			<div class="card-header pt-5">
				<h3 class="card-title align-items-start flex-column">
				<span class="card-label fw-bold text-dark">Performance</span>
				<span class="text-gray-400 mt-1 fw-semibold fs-6">1,046 Inbound Calls today</span>
				</h3>
				<div class="card-toolbar">
					<div data-kt-daterangepicker="true" data-kt-daterangepicker-opens="left" data-kt-daterangepicker-range="today" class="btn btn-sm btn-light d-flex align-items-center px-4">
						<div class="text-gray-600 fw-bold">Loading date range...</div>
						<i class="ki-duotone ki-calendar-8 fs-1 ms-2 me-0">
						<span class="path1"></span>
						<span class="path2"></span>
						<span class="path3"></span>
						<span class="path4"></span>
						<span class="path5"></span>
						<span class="path6"></span>
						</i>
					</div>
				</div>
			</div>
			<div class="card-body d-flex align-items-end p-0">
				<div id="kt_charts_widget_36" class="min-h-auto w-100 ps-4 pe-6" style="height: 300px"></div>
			</div>
		</div>
	</div>
</div>


@endsection