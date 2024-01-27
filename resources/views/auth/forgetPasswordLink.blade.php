<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/css/bootstrap.min.css'>
    <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css'>
    <link rel='stylesheet' href='https://fonts.googleapis.com/css?family=Lato:300,400'>
    <meta charset="utf-8" />
		<title>Reset Password </title>
		<meta name="description" content="Singin page example" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<link rel="shortcut icon" href="{{ asset('media/logos/Logo_PLN.png') }}" />
		<!--begin::Fonts-->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
		<!--end::Fonts-->
		<!--end::Page Custom Styles-->
		<link href="{{ asset ('css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
		<!--end::Global Theme Styles-->
		<!--end::Layout Themes-->
    <link rel='stylesheet' href='{{ asset('css/custom.css') }}'>
    
</head>

<body   id="kt_body" style="background:#222 url('{{ asset('media/logos/bg_900.png') }}') no-repeat center center;background-size:cover;background-position: right top">
    <!--begin::Main-->
		<div class="d-flex flex-column flex-root" style="background:url('{{ asset('media/logos/form700.png') }}') no-repeat center center;background-size:90% 100%; background-position: left top ">
			
      <div class="pt-10 pr-10 text-right">
        <img src="{{ asset('media/logos/logo pln.png') }}" class="max-h-100px" alt="" />
      </div>
      <!--begin::Login-->
			<div class="login login-4 wizard d-flex flex-column flex-lg-row flex-column-fluid ">
				
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
              <form class="" method="POST" action="{{ route('reset.password.post') }}" enctype="multipart/form-data">
                @csrf
								<input type="hidden" name="token" value="{{ $token }}">
                <fieldset>
                  <!-- Email input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="textinput">Email <span id="popover-email"
                        class="hide pull-right block-help"><i class="fa fa-info-circle text-danger" aria-hidden="true"></i> Enter an
                        valid email address</span></label>
                    <div class="col-md-12">
                      @error('email')
                        <div class="alert alert-danger" role="alert">
                          {{ $errors->first('email') }}
                        </div>
                      @enderror
                      <input id="email" name="email" type="email" placeholder="" class="form-control input-md" required :value="old('email')">
                    </div>
                  </div>
                  <!-- Password input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="passwordinput">Password </label>
                    <div class="col-md-12">
                      @error('password')
                        <div class="alert alert-danger" role="alert">
                          {{ $errors->first('password') }}
                        </div>
                      @enderror
                      <input id="password" name="password" type="password" placeholder="" autocomplete="off" class="form-control input-md"
                        data-placement="bottom" data-toggle="popover" data-container="body" type="button" data-html="true" required :value="old('password')">
                      <div id="popover-password">
                        <ul class="list-unstyled pt-2">
                          <li class=""><span class="low-upper-case">
                            <i class="fa fa-file-text" aria-hidden="true"></i></span>
                            &nbsp; 1 lowercase &amp; 1 uppercase
                          </li>
                          <li class="">
                            <span class="one-number"><i class="fa fa-file-text" aria-hidden="true"></i></span> 
                            &nbsp; 1 Mengandung Nomor (0-9)
                          </li>
                          <li class="">
                            <span class="one-special-char"><i class="fa fa-file-text" aria-hidden="true"></i></span>
                            &nbsp; 1 Spesial karakter (!@#$%^&*).
                          </li>
                          <li class="">
                            <span class="eight-character"><i class="fa fa-file-text" aria-hidden="true"></i></span>&nbsp;
                            &nbsp; Minimal 8 Karakter
                          </li>
                        </ul>

                      </div>
                    </div>
                  </div>
                  <!-- Password input-->
                  <div class="form-group">
                    <label class="col-md-12 control-label" for="passwordinput">Password Confirmation <span id="popover-cpassword"
                        class="hide pull-right block-help"><i class="fa fa-info-circle text-danger" aria-hidden="true"></i> Password
                        don't
                        match</span></label>
                    <div class="col-md-12">
                      @error('password_confirmation')
                        <div class="alert alert-danger" role="alert">
                          {{ $errors->first('password_confirmation') }}
                        </div>
                      @enderror
                      <input id="confirm-password" name="password_confirmation" type="password" placeholder=""
                        class="form-control input-md" required :value="old('password_confirmation')">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="col-md-12 pt-5">
                      <button style="display:none" id="sign-up" type="submit" class="btn btn-primary btn-block">Reset Password</button>
                      <button id="sign-up_disabled" disabled class="btn btn-default btn-block">Reset Password</button>
                    </div>
                  </div>
                </fieldset>
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
    <!-- partial -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.7/js/bootstrap.min.js'></script>
    <script src='{{ asset('js/password-strength-check-reset-password.js') }}'></script>
</body>

</html>
