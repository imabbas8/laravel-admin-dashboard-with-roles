<div id="kt_app_sidebar" class="app-sidebar flex-column" data-kt-drawer="true" data-kt-drawer-name="app-sidebar" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="225px" data-kt-drawer-direction="start" data-kt-drawer-toggle="#kt_app_sidebar_mobile_toggle">
	<div class="app-sidebar-logo px-6" id="kt_app_sidebar_logo">
		<a href="{{route('admin.dashboard')}}">
			<img alt="Logo" src="{{url('assets/logos/navlogo.png')}}" class="h-30px app-sidebar-logo-default" />
			<!-- <img alt="Logo" src="{{url('assets/logos/navlogo.png')}}" class="h-30px app-sidebar-logo-minimize" /> -->
		</a>
		<div id="kt_app_sidebar_toggle" class="app-sidebar-toggle btn btn-icon btn-shadow btn-sm btn-color-muted btn-active-color-primary h-30px w-30px position-absolute top-50 start-100 translate-middle rotate" data-kt-toggle="true" data-kt-toggle-state="active" data-kt-toggle-target="body" data-kt-toggle-name="app-sidebar-minimize">
			<i class="ki-duotone ki-black-left-line fs-3 rotate-180">
			<span class="path1"></span>
			<span class="path2"></span>
			</i>
		</div>
	</div>
	<div class="app-sidebar-menu overflow-hidden flex-column-fluid">
		<div id="kt_app_sidebar_menu_wrapper" class="app-sidebar-wrapper">
			<div id="kt_app_sidebar_menu_scroll" class="scroll-y my-5 mx-3" data-kt-scroll="true" data-kt-scroll-activate="true" data-kt-scroll-height="auto" data-kt-scroll-dependencies="#kt_app_sidebar_logo, #kt_app_sidebar_footer" data-kt-scroll-wrappers="#kt_app_sidebar_menu" data-kt-scroll-offset="5px" data-kt-scroll-save-state="true">
				<div class="menu menu-column menu-rounded menu-sub-indention fw-semibold fs-6" id="#kt_app_sidebar_menu" data-kt-menu="true" data-kt-menu-expand="false">

					@can('admin.dashboard')
					<div class="menu-item">
						<a class="menu-link" href="{{route('admin.dashboard')}}">
							<span class="menu-icon">
								<i class="fas fa-home "></i>
							</span>
							<span class="menu-title">Dashboard</span>
						</a>
					</div>
					@endcan

					@if($authUser->hasRole('super-admin'))
					<div data-kt-menu-trigger="click"
					 class="menu-item menu-accordion 
					@if(request()->segment(1) == 'modules') hover show @endif">
						<span class="menu-link">
							<span class="menu-icon">
								<i class="fas fa-user"></i>
							</span>
							<span class="menu-title">Modules Managment</span>
							<span class="menu-arrow"></span>
						</span>
						<div class="menu-sub menu-sub-accordion">
								<div class="menu-item">
									<a class="menu-link 
									@if(request()->route()->getName() == 'admin.super-modules-list') active @endif" href="{{route('admin.super-modules-list')}}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Refresh Permission</span>
									</a>
								</div>
								
							</div>

						</div>
					@endif


					@if($authUser->can('admin.user-create') 
					|| $authUser->can('admin.user-list')
					 || $authUser->can('admin.user-trash-list') 
					 || $authUser->can('admin.role-list')
					 )

					
					<div data-kt-menu-trigger="click" class="menu-item menu-accordion 
					@if(request()->segment(1) == 'user' || request()->segment(2) == 'role') hover show @endif">
						<span class="menu-link">
							<span class="menu-icon">
								<i class="fas fa-user"></i>
							</span>
							<span class="menu-title">User Managment  </span>
							<span class="menu-arrow"></span>
						</span>

						
						@can('admin.user-create')
							<div class="menu-sub menu-sub-accordion">
								<div class="menu-item">
									<a class="menu-link @if(request()->route()->getName() == 'admin.user-create')active @endif" href="{{route('admin.user-create')}}">
										<span class="menu-bullet">
											<span class="bullet bullet-dot"></span>
										</span>
										<span class="menu-title">Add New</span>
									</a>
								</div>
								
							</div>
						@endcan

						@can('admin.user-list')

						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link @if(request()->route()->getName() == 'admin.user-list' || request()->route()->getName() == 'user-permission') active @endif" href="{{route('admin.user-list')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">User List</span>
								</a>
							</div>
							
						</div>
						@endcan

						@can('admin.user-trash-list')
						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link @if(request()->route()->getName() == 'admin.user-trash-list') active @endif" href="{{route('admin.user-trash-list')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">User Trash</span>
								</a>
							</div>
							
						</div>
						@endcan

						@can('admin.role-list')

						<div class="menu-sub menu-sub-accordion">
							<div class="menu-item">
								<a class="menu-link @if(request()->segment(2) == 'role') active @endif" href="{{route('admin.role-list')}}">
									<span class="menu-bullet">
										<span class="bullet bullet-dot"></span>
									</span>
									<span class="menu-title">Role List</span>
								</a>
							</div>
							
						</div>


					@endcan

						

					</div>
					@endif				
				</div>
			</div>
		</div>
	</div>
</div>