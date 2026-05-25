<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
	<head>
		<title>Error</title>
		<meta charset="utf-8" />
		
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
		<link href="{{url('assets/plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{url('assets/css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<style>
				body { background-image: url('assets/media/auth/bg1.jpg'); }
			[data-bs-theme="dark"] body { background-image: url('assets/media/auth/bg1-dark.jpg'); }
		</style>
		
	</head>
	<body id="kt_body" class="app-blank bgi-size-cover bgi-position-center bgi-no-repeat">
		
		<div class="d-flex flex-column flex-root" id="kt_app_root">
			
			<div class="d-flex flex-column flex-center flex-column-fluid">
				
				<div class="d-flex flex-column flex-center text-center p-10">
					
					<div class="card card-flush w-lg-650px py-5">
						<div class="card-body py-15 py-lg-20">
							
							<h1 class="fw-bolder fs-2hx text-gray-900 mb-4">Oops!</h1>
							
							<div class="fw-semibold fs-6 text-gray-500 mb-7">We can't find that page.</div>
							
							<div class="mb-3">

								<img src="{{url('assets/media/auth/505-error.png')}}" class="mw-100 mh-300px theme-light-show" alt="" />
								<img src="{{url('assets/media/auth/505-error-dark.png')}}" class="mw-100 mh-300px theme-dark-show" alt="" />
							</div>
							
							<div class="mb-0">
								<a href="{{ url()->previous() }}" class="btn btn-sm btn-primary">Go Back</a>
							</div>
							
						</div>
					</div>
					
				</div>
				
			</div>
			
		</div>
		
		<script>var hostUrl = "assets/";</script>
		
		<script src="{{url('assets/plugins/global/plugins.bundle.js')}}"></script>
		<script src="{{url('assets/js/scripts.bundle.js')}}"></script>
		
	</body>
</html>