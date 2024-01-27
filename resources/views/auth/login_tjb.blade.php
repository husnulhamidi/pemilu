
<!DOCTYPE html>
<!--
Template Name: Metronic - Bootstrap 4 HTML, React, Angular 11 & VueJS Admin Dashboard Theme
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: https://1.envato.market/EA4JP
Renew Support: https://1.envato.market/EA4JP
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">
	<!--begin::Head-->
	<head>
		<meta charset="utf-8" />
		<title>Sign In </title>
		<meta name="description" content="Singin page example" />
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<link rel="shortcut icon" href="{{ asset('media/logos/Logo_PLN.png') }}" />
		<!--begin::Fonts-->
		
		<!--end::Fonts-->
		<!--begin::Page Custom Styles(used by this page)-->
		<link href="{{ asset('css/pages/login/login-4.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Page Custom Styles-->
		<!--begin::Global Theme Styles(used by all pages)-->
		<link href="{{ asset('plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset ('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--begin::Layout Themes(used by all pages)-->
		<link href="{{ asset('css/themes/layout/header/base/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/header/menu/light.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/brand/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset('css/themes/layout/aside/dark.css') }}" rel="stylesheet" type="text/css" />
		<link href="{{ asset ('css/custom.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Layout Themes-->
		
	</head>
	<!--end::Head-->
	<!--begin::Body-->
	<body  id="kt_body"  style="background:#222 url('{{ asset('media/logos/bg_900.png') }}') no-repeat center center;background-size:cover;background-position: right top ">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root" style="background:url('{{ asset('media/logos/form700.png') }}') no-repeat center center;background-size:90% 100%; background-position: left top ">
				<div class="pt-10 pr-10 text-right">
					<img src="{{ asset('media/logos/logo pln.png') }}" class="max-h-100px" alt="" />
				</div>
				<!--begin::Content-->
				<div class="col-lg-4 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-transparent">
					<!--begin::Wrapper-->
					<div  class="login-content d-flex flex-column pt-lg-0 pt-12 bg-transparent pr-5 pl-5" style="border-radius:10px;width:100%;">
						<!--begin::Logo-->
						<div class="login-logo pb-3 text-center">
							
							<h3 class="text-center"><b>SIP</b></h3>
							<h6 class="text-center">Sistem Informasi Pemilu</h6>
						</div>
						<!--end::Logo-->
						
						<!--begin::Signin-->
						<div class="login-form">
							<!--begin::Form-->
							<form class="form" id="kt_login_singin_form" method="POST" action="{{ route('action-login') }}">
								@csrf
								<!--begin::Title-->
								<div class="pb-2 ">
									{{-- <h4 class=" text-dark ">Silahkan masukkan Email dan Password !</h4> --}}
								</div>
								<!--begin::Title-->

								@if(session('error'))
								<div class="alert alert-danger">
									<b>Login gagal !, </b> {{session('error')}}
								</div>
								@endif

								@if(session('success'))
								<div class="alert alert-success">
									<b>Success !</b> {{session('success')}}
								</div>
								@endif

								<!--begin::Form group-->
								<div class="form-group">
									<label class="font-size-h6 font-weight-bolder text-dark">Email</label>
									<input class="form-control form-control-solid h-auto py-4 px-5  border-0" id="email" type="email" name="email" autocomplete="off" required :value="old('email')" />
								</div>
								<!--end::Form group-->
								<!--begin::Form group-->
								<div class="form-group">
									<div class="d-flex justify-content-between mt-n5">
										<label class="font-size-h6 font-weight-bolder text-dark pt-5">Password</label>
										{{-- <a href="#" class="text-primary font-size-h6 font-weight-bolder text-hover-primary pt-5">Forgot Password ?</a> --}}
									</div>
									<div class="input-icon input-icon-right">
										<input id="password-field" class="form-control form-control-solid h-auto py-4 px-5 border-0" type="password" name="password" autocomplete="current-password" required />
										<span toggle="#password-field" class="far fa-eye-slash icon-md toggle-password"></span>
									</div>
									<div class="checkbox-inline pt-3">
										<label class="checkbox checkbox-primary">
											<input type="checkbox" id="rememberemail" name="rememberemail" onclick="RememberEmail()">
											<span></span>Simpan email
										</label>
									</div>
								</div>
								
								<!--end::Form group-->
								<!--begin::Action-->
								<div class="pb-lg-0 pb-5">
									<a href="{{ route('password.request') }}" class="text-warning text-hover-dark"><p>Lupa Password ? Reset Sekarang. </p></a> 
									<button type="submit" id="kt_login_singin_form_submit_button" class="btn btn-success  btn-block">Sign In</button>
									
									<br><h6 class="text-left">PT PLN (PERSERO) UIK TANJUNG JATI B</h6>
									{{-- <button type="button" class="btn btn-light-primary font-weight-bolder px-8 py-4 my-3 font-size-lg">
									<span class="svg-icon svg-icon-md">

									</span>Forgot Password?</button> --}}
								</div>
								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Wrapper-->
				</div>
			
			
				
				
				
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
		<!--end::Global Theme Bundle-->
		<!--begin::Page Scripts(used by this page)-->
		<!-- <script src="{{ asset('js/pages/custom/login/login-4.js') }}"></script> -->
		<script src="{{ asset('js/module/auth/togglepassword.js?random='.date('ymdHis')) }}" type="text/javascript"></script>
		<!--end::Page Scripts-->
	</body>
	<!--end::Body-->
</html>
