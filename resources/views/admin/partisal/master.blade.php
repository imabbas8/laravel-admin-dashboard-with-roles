<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Dashboard</title>
		<meta charset="utf-8" />
		<link rel="shortcut icon" href="assets/media/logos/favicon.ico" />
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		@stack('css')
	</head>
	<body id="kt_app_body" data-kt-app-layout="dark-sidebar" data-kt-app-header-fixed="true" data-kt-app-sidebar-enabled="true" data-kt-app-sidebar-fixed="true" data-kt-app-sidebar-hoverable="true" data-kt-app-sidebar-push-header="true" data-kt-app-sidebar-push-toolbar="true" data-kt-app-sidebar-push-footer="true" data-kt-app-toolbar-enabled="true" class="app-default">
		
		@include('admin.partisal.theme_script')
		<div class="d-flex flex-column flex-root app-root" id="kt_app_root">
			<div class="app-page flex-column flex-column-fluid" id="kt_app_page">
				@include('admin.partisal.header')
				<div class="app-wrapper flex-column flex-row-fluid" id="kt_app_wrapper">
					@include('admin.partisal.side_bar')
					<div class="app-main flex-column flex-row-fluid" id="kt_app_main">
						<div class="d-flex flex-column flex-column-fluid">
							<div id="kt_app_content" class="app-content flex-column-fluid">
								<div id="kt_app_content_container" class="app-container container-fluid">
									@yield('breadcrumb')
									@yield('content')
								</div>
							</div>
						</div>
						@include('admin.partisal.footer')
					</div>
					
					
				</div>
			</div>
		</div>
		@include('admin.partisal.chat')
		<div id="kt_scrolltop" class="scrolltop" data-kt-scrolltop="true">
			<i class="ki-duotone ki-arrow-up">
			<span class="path1"></span>
			<span class="path2"></span>
			</i>
		</div>
		<script>var hostUrl = "assets/";</script>
		<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
		
		@stack('scripts')
		
	</body>
</html>