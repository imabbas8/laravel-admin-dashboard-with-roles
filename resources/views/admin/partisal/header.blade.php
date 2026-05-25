<div id="kt_app_header" class="app-header" data-kt-sticky="true" data-kt-sticky-activate="{default: true, lg: true}" data-kt-sticky-name="app-header-minimize" data-kt-sticky-offset="{default: '200px', lg: '0'}" data-kt-sticky-animation="false">
	<div class="app-container container-fluid d-flex align-items-stretch justify-content-between" id="kt_app_header_container">
		<div class="d-flex align-items-center d-lg-none ms-n3 me-1 me-md-2" title="Show sidebar menu">
			<div class="btn btn-icon btn-active-color-primary w-35px h-35px" id="kt_app_sidebar_mobile_toggle">
				<i class="ki-duotone ki-abstract-14 fs-2 fs-md-1">
				<span class="path1"></span>
				<span class="path2"></span>
				</i>
			</div>
		</div>
		<div class="d-flex align-items-center flex-grow-1 flex-lg-grow-0">
			<a href="{{route('admin.dashboard')}}" class="d-lg-none">
				<img alt="Logo" src="{{url('assets/logos/navlogo.png')}}" class="h-30px" />
			</a>
		</div>
		<div class="d-flex align-items-stretch justify-content-between flex-lg-grow-1" id="kt_app_header_wrapper">
			<div class="app-header-menu app-header-mobile-drawer align-items-stretch" data-kt-drawer="true" data-kt-drawer-name="app-header-menu" data-kt-drawer-activate="{default: true, lg: false}" data-kt-drawer-overlay="true" data-kt-drawer-width="250px" data-kt-drawer-direction="end" data-kt-drawer-toggle="#kt_app_header_menu_toggle" data-kt-swapper="true" data-kt-swapper-mode="{default: 'append', lg: 'prepend'}" data-kt-swapper-parent="{default: '#kt_app_body', lg: '#kt_app_header_wrapper'}">
			</div>
			<div class="app-navbar flex-shrink-0">
				<div class="app-navbar-item ms-1 ms-md-4">
					<div class="btn btn-icon btn-custom btn-icon-muted btn-active-light btn-active-color-primary w-35px h-35px position-relative" id="kt_drawer_chat_toggle">
						<i class="ki-duotone ki-message-text-2 fs-2">
						<span class="path1"></span>
						<span class="path2"></span>
						<span class="path3"></span>
						</i>
						<span class="bullet bullet-dot bg-success h-6px w-6px position-absolute translate-middle top-0 start-50 animation-blink"></span>
					</div>
				</div>
				<div class="app-navbar-item ms-1 ms-md-4" id="kt_header_user_menu_toggle">
					<div class="cursor-pointer symbol symbol-35px" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
						<img src="{{url('assets/media/avatars/300-3.jpg')}}" class="rounded-3" alt="user" />
					</div>
					<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg menu-state-color fw-semibold py-4 fs-6 w-275px" data-kt-menu="true">
						<div class="menu-item px-3">
							<div class="menu-content d-flex align-items-center px-3">
								<div class="d-flex flex-column">
									<div class="fw-bold d-flex align-items-center fs-5">{{ucfirst($authUser->name)}}
										<span class="badge badge-light-success fw-bold fs-8 px-2 py-1 ms-2">{{ucfirst($authUser->roles[0]->name)}}</span></div>
										<a href="#" class="fw-semibold text-muted text-hover-primary fs-7">{{$authUser->email}}</a>
									</div>
								</div>
							</div>
							@can('admin.profile-setting')
								<div class="separator my-2"></div>
								<div class="menu-item px-5">
									<a href="{{route('admin.profile-setting')}}" class="menu-link px-5">My Profile</a>
								</div>
							@endcan

							@can('admin.profile-setting')
								<div class="separator my-2"></div>
								<div class="menu-item px-5">
									<a href="{{route('admin.password-change')}}" class="menu-link px-5">Change Password</a>
								</div>
							@endcan

							

							<div class="separator my-2"></div>
							<div class="menu-item px-5" data-kt-menu-trigger="{default: 'click', lg: 'hover'}" data-kt-menu-placement="left-start" data-kt-menu-offset="-15px, 0">
								<a href="#" class="menu-link px-5">
									<span class="menu-title position-relative">Mode
										<span class="ms-5 position-absolute translate-middle-y top-50 end-0">
											<i class="ki-duotone ki-night-day theme-light-show fs-2">
											<span class="path1"></span>
											<span class="path2"></span>
											<span class="path3"></span>
											<span class="path4"></span>
											<span class="path5"></span>
											<span class="path6"></span>
											<span class="path7"></span>
											<span class="path8"></span>
											<span class="path9"></span>
											<span class="path10"></span>
											</i>
											<i class="ki-duotone ki-moon theme-dark-show fs-2">
											<span class="path1"></span>
											<span class="path2"></span>
											</i>
										</span></span>
									</a>
									<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-title-gray-700 menu-icon-gray-500 menu-active-bg menu-state-color fw-semibold py-4 fs-base w-150px" data-kt-menu="true" data-kt-element="theme-mode-menu">
										<!--begin::Menu item-->
										<div class="menu-item px-3 my-0">
											<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
												<span class="menu-icon" data-kt-element="icon">
													<i class="ki-duotone ki-night-day fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													<span class="path5"></span>
													<span class="path6"></span>
													<span class="path7"></span>
													<span class="path8"></span>
													<span class="path9"></span>
													<span class="path10"></span>
													</i>
												</span>
												<span class="menu-title">Light</span>
											</a>
										</div>
										<div class="menu-item px-3 my-0">
											<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
												<span class="menu-icon" data-kt-element="icon">
													<i class="ki-duotone ki-moon fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													</i>
												</span>
												<span class="menu-title">Dark</span>
											</a>
										</div>
										<div class="menu-item px-3 my-0">
											<a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
												<span class="menu-icon" data-kt-element="icon">
													<i class="ki-duotone ki-screen fs-2">
													<span class="path1"></span>
													<span class="path2"></span>
													<span class="path3"></span>
													<span class="path4"></span>
													</i>
												</span>
												<span class="menu-title">System</span>
											</a>
										</div>
									</div>
								</div>
								<div class="menu-item px-5">
									<a class="menu-link px-5" href="{{ route('logout') }}"
										onclick="event.preventDefault();
										document.getElementById('logout-form').submit();">
										Sign Out
									</a>
									<form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
										@csrf
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>