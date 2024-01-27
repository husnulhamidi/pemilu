
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
		<title>Reset Password </title>
		<meta name="description" content="Singin page example" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="canonical" href="https://keenthemes.com/metronic" />
		<link rel="shortcut icon" href="{{ asset('media/logos/Logo_PLN.png') }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
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
	<body id="kt_body"  style="background:#222 url('{{ asset('media/logos/bg1.png') }}') no-repeat center center;background-size:cover;background-position: right top ">
		<!--begin::Main-->
		<div class="d-flex flex-column flex-root" style="">
			<div class="pt-10 pr-10 text-right">
				<img src="{{ asset('media/logos/invoicex.png') }}" class="max-h-100px" alt="" />
			</div>
			<!--begin::Login-->
			<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid ">
				
				<!--begin::Content-->
				<div class="col-lg-4 d-flex flex-center flex-row-fluid px-7 pt-lg-0 pb-lg-0 pt-4 pb-6 bg-transparent">
					<!--begin::Wrapper-->
					<div  class="login-content d-flex flex-column pt-lg-0 pt-12 bg-white pr-5 pl-5 " style="border-radius:10px;width:100%;opacity:0.8">
						<!--begin::Logo-->
						<div class="login-logo pb-5 text-center">
							<h3 class="text-left text-green-light-tjb text-app"><b>SIP</b></h3>
							<h6 class="text-left">Sistem Informasi Pemilu</h6>
							<br><br>
						</div>
						<!--end::Logo-->
						
						<!--begin::Signin-->
						<div class="login-form">
							<!--begin::Form-->
							<form class="form" id="kt_login_singin_form" method="POST" action="{{ route('password.update') }}">
								@csrf
								<!--begin::Title-->
								<div class="pb-2 ">
									<p class=" text-dark ">Silahkan masukkan Email yang akan direset !</p>
								</div>
								
								<!--begin::Title-->

								<!--begin::Form group-->
								<div class="form-group">
									<input class="form-control form-control-solid h-auto py-4 px-5 border-0" type="email" name="email" id="email" autocomplete="off" required :value="old('email')" />
                                    {{-- <div class="pt-5 checking-email"></div> --}}
                                </div>

                                @if(session('error'))
								<div class="alert alert-danger">
									<b>Opps!</b> {{session('error')}}
								</div>
								@endif

                                @if(session('success'))
								<div class="alert alert-success">
									<b>Success!</b> {{session('success')}}
								</div>
								@endif
                                
								<!--end::Form group-->
								<!--begin::Form group-->
								
								<!--end::Form group-->
								<!--begin::Action-->
								<div class="pb-lg-0 pb-5">
									<button style="display:none" type="submit" id="kt_form_submit_reset_password" class="btn btn-success btn-block font-weight-bolder  my-3 mr-3"> Reset Password</button>
									<button disabled id="kt_form_submit_reset_password_disabled" class="btn btn-outline-success btn-block font-weight-bolder  my-3 mr-3"> Reset Password</button>
									<div class='text-right'>
										<a href="{{ route('login') }}" class="">  Kembali ke halaman Login. </a> 
									</div>
									
									<br>
									<h6 class="text-center">PEMILU 2024</h6>
								</div>
                                <br>
								<!--end::Action-->
							</form>
							<!--end::Form-->
						</div>
						<!--end::Signin-->
					</div>
					<!--end::Wrapper-->
				</div>
				<!--begin::Content-->
				
			</div>
			<!--end::Login-->
		</div>
		<!--end::Main-->
		<script>var HOST_URL = "https://preview.keenthemes.com/metronic/theme/html/tools/preview";</script>
		<!--begin::Global Config(global config for global JS scripts)-->
		<script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1400 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#E4E6EF", "dark": "#181C32" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#EBEDF3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#3F4254", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#EBEDF3", "gray-300": "#E4E6EF", "gray-400": "#D1D3E0", "gray-500": "#B5B5C3", "gray-600": "#7E8299", "gray-700": "#5E6278", "gray-800": "#3F4254", "gray-900": "#181C32" } }, "font-family": "Poppins" };</script>
		<!--end::Global Config-->
        @section('scripts')
    <script>
        const url_verifyemail = "{{route('verification.notice')}}";
    </script>
		<!--begin::Global Theme Bundle(used by all pages)-->
		<script src="{{ asset('plugins/global/plugins.bundle.js') }}"></script>
		<script src="{{ asset('plugins/custom/prismjs/prismjs.bundle.js') }}"></script>
		<script src="{{ asset('js/scripts.bundle.js') }}"></script>
        <script src="{{ asset('js/reset_password.js?random='.date('ymdHis')) }}" defer></script>
		<!--end::Global Theme Bundle-->
		
	</body>
	<!--end::Body-->
</html>
