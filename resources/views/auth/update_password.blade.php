
<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" {{ Metronic::printAttrs('html') }} {{ Metronic::printClasses('html') }}>
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>Update Password</title>
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
        <meta http-equiv="Pragma" content="no-cache" />
        <meta http-equiv="Expires" content="0" />

		{{-- Meta Data --}}
        <meta name="description" content="@yield('page_description', $page_description ?? '')"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"/>
        
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{ asset('css/pages/login/classic/login-4.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('plugins/global/plugins.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/style.bundle.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{ asset('css/themes/layout/header/base/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/header/menu/light.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/brand/dark.css')}}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/aside/dark.css')}}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		<link rel="shortcut icon" href="{{ asset('media/logos/Logo_PLN.png') }}" />
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body id="kt_body" class="header-fixed header-mobile-fixed subheader-enabled subheader-fixed aside-enabled aside-fixed aside-minimize-hoverable page-loading">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root">
			<!--begin::Login-->
			<div class="login login-4 login-signin-on d-flex flex-row-fluid" id="kt_login">
				<div class="d-flex flex-center flex-row-fluid bgi-size-cover bgi-position-top bgi-no-repeat" style="background-image: url('{{ asset('media/bg/bg-3.jpg')}}');">
					<div class="login-form text-center p-7 position-relative overflow-hidden">
						<!--begin::Login Header-->
						<div class="d-flex flex-center mb-5">
							<a href="#">
								<img src="{{ asset('media/logos/Logo_PLN.png') }}" class="max-h-75px" alt="" />
							</a>
						</div>
						<!--end::Login Header-->
						<!--begin::Login Sign in form-->
						<div class="login-signin">
							<div class="mb-5">
								<h3>PERINGATAN !</h3>
								<div class="text-muted font-weight-bold">{{$message}}</div>
							</div>
							<form class="form" method="post" action="javascript:;" id="kt_update_password_form" enctype="multipart/form-data">
								
								<div class="form-group mb-5 text-left">
									Password
									<input class="form-control h-auto form-control-solid " type="password" placeholder="Password" name="password_up" id="password_up" autocomplete="off" />
									<ul class="list-unstyled pt-2">
										<li class=""><span class="low-upper-case">
											<i class="fas fa-file-alt" aria-hidden="true"></i></span>
											&nbsp; 1 lowercase &amp; 1 uppercase
										</li>
										<li class="">
											<span class="one-number"><i class="fas fa-file-alt" aria-hidden="true"></i></span> 
											&nbsp; 1 Mengandung Nomor (0-9)
										</li>
										<li class="">
											<span class="one-special-char"><i class="fas fa-file-alt" aria-hidden="true"></i></span>
										  &nbsp; 1 Spesial karakter (!@#$%^&*).
										</li>
										<li class="">
											<span class="eight-character"><i class="fas fa-file-alt" aria-hidden="true"></i></span>&nbsp;
											&nbsp; Minimal 8 Karakter
										</li>
									</ul>
								</div>
								<div class="form-group mb-5 text-left">
									Konfirmasi Password
									<input class="form-control h-auto form-control-solid " type="password" placeholder="konfirmassi Password" name="cpassword" id="cpassword" />
								</div>
								
								<button style="display:none" type="submit" id="kt_update_password_submit" class="btn btn-primary font-weight-bold text-left">Update Password</button> 
								<button disabled id="kt_update_password_submit_disabled" class="btn btn-default font-weight-bold text-left">Update Password</button> 
							</form>
							<div class="mt-5">
								@if ($status=='2')
									<a href="{{ route('dashboard') }}"  class="text-muted text-hover-primary font-weight-bold">Lewati (menuju ke halaman dashboard)</a>
								@endif
							</div>
						</div>

					<div class="panel-logout" style="display: none">
						<h3>UPDATE PASSWORD SUKSES !</h3>
						<div class="text-muted font-weight-bold">Silahkan log out terlebih dahulu, kemudian login lagi dengan password baru.</div>
						<form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                <button  class="btn btn-danger font-weight-bold text-left">Log Out</button> 
                            </x-dropdown-link>
                        </form>
					</div>
						
					</div>
				</div>
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>
			var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };
			const update_password_url = "{{route('submit-updatepass')}}";
		</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		{{-- <script src="{{ asset('js/pages/custom/login/login-general.js') }}"></script> --}}
		<script src="{{ asset('js/module/auth/update_password.js?random='.date('ymdHis')) }}" type="text/javascript"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>