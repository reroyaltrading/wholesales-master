<!DOCTYPE html>
<html lang="en" ng-app="WholeSale">
<head>
	<title>WholeSale - Login</title>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/vendor/bootstrap/css/bootstrap.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/fonts/Linearicons-Free-v1.0.0/icon-font.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/vendor/animate/animate.css') }}">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/vendor/css-hamburgers/hamburgers.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/vendor/select2/select2.min.css') }}">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/css/util.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/loginv11/css/main.css') }}">
<!--===============================================================================================-->

    <meta name="robots" content="index, follow" />
    <meta name="generator" content="Laravel 5.8">
    <link rel="manifest" href="{{ asset('manifest.json') }}">
</head>
<body ng-controller="LoginController">
	<input class="" type="hidden" name="base_url" id="base_url" value="{{ asset('/') }}" />
	<input class="" type="hidden" name="current_url" id="current_url" value="{{url()->current()}}" />
	<div class="limiter">
		<div class="container-login100" style="background-image: url({{ asset('public/images/background2.jpeg') }}); background-position: center; background-repeat: no-repeat; background-size: cover;">
			<div class="wrap-login100 p-l-50 p-r-50 p-t-30 p-b-30">
				<form class="login100-form validate-form" ng-submit="DoLogin()">
					<span class="login100-form-title p-b-20">
                    <img src="{{ asset('public/images/wholesales_dark.png') }}" class="img-fluid"/>
					</span>

					<div class="wrap-input100 validate-input m-b-16" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100" type="text" name="email"  ng-model="user.username"  placeholder="Email">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-envelope"></span>
						</span>
					</div>

					<div class="wrap-input100 validate-input m-b-16"  data-validate = "Password is required">
						<input class="input100" type="password" ng-model="user.password"  name="pass" placeholder="Password">
						<span class="focus-input100"></span>
						<span class="symbol-input100">
							<span class="lnr lnr-lock"></span>
						</span>
					</div>

					<div class="contact100-form-checkbox m-l-4">
						<input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
						<label class="label-checkbox100" for="ckb1">
							Remember me
						</label>
					</div>
					
					<div class="container-login100-form-btn p-t-25">
						<button class="login100-form-btn" type="submit">
							<span ng-show="logging"><i class="fa fa-spin fa-spinner"></i></span>Login
						</button>
					</div>

					<div class="text-center w-full" style="padding-top: 20px;">
						<span class="txt1">
							Not a member?
						</span>

						<a class="txt1 bo1 hov1" href="{{ route('register_index') }}">
							Sign up now							
						</a>
                    </div>
                    <div class="text-center w-full" style="padding-top: 20px;">
                            <a class="txt1 bo1 hov1" href="{{ route('recover_index') }}">Recover Account</a>
                    </div>
				</form>
			</div>
		</div>
	</div>
	
	

	
<!--===============================================================================================-->	
	<script src="{{ asset('public/loginv11/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('public/loginv11/vendor/bootstrap/js/popper.js') }}"></script>
	<script src="{{ asset('public/loginv11/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
	<script src="{{ asset('public/loginv11/vendor/select2/select2.min.js') }}"></script>
<!--===============================================================================================-->

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ asset('public/js/bootstrap-notify.min.js') }}"></script>
    <script src="{{ asset('public/js/pace.min.js') }}"></script>
    <script src="{{ asset('public/plugins/dropzone/dropzone.js') }}"></script>
	<script src="{{ asset('public/js/scope.js') }}"></script>
	<script src="{{ asset('public/controller/LoginController.js') }}"></script>
    <script>
		if ('serviceWorker' in navigator) {
				window.addEventListener('load', function() {
						navigator.serviceWorker.register('/sw.js').then(function(registration) {
						// Registration was successful
						console.log('ServiceWorker registration successful with scope: ', registration.scope);
						}, function(err) {
						// registration failed :(
						console.log('ServiceWorker registration failed: ', err);
						});
				});
		}
</script>
</body>
</html>