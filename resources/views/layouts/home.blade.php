<!DOCTYPE HTML>
<html lang="en" ng-app="WholeSale">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="author" content="Bootstrap-ecommerce by Vosidiy">

<title>WholeSales - {{ isset($page_title) ? $page_title : '' }}</title>

<link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

<meta name="description" content="{{ isset($page_description) ? $page_description : '' }}">
<link rel="canonical" href="{{ url('/') }}">
<link rel="publisher" href="https://reroyaltrading.ca">
<meta property="og:locale" content="en_CA">
<meta property="og:type" content="website">
<meta property="og:title" content="WholeSales - {{ isset($page_title) ? $page_title : '' }}">
<meta property="og:description" content="{{ isset($page_description) ? $page_description : '' }}">

@if(isset($images))
	<meta property="og:image" content="{{ count($images) > 0 ? url('storage/'.$images[0]->location) : '' }}">
@endif

<meta name="robots" content="index, follow" />
<meta name="generator" content="Laravel 5.8">

<!-- jQuery -->
<script src="{{ asset('public/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>

<!-- Bootstrap4 files-->
<script src="{{ asset('public/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet" type="text/css"/>

<!-- Font awesome 5 -->
<link href="{{ asset('public/fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">

<!-- plugin: fancybox  -->
<script src="{{ asset('public/plugins/fancybox/fancybox.min.js') }}" type="text/javascript"></script>
<link href="{{ asset('public/plugins/fancybox/fancybox.min.css') }}" type="text/css" rel="stylesheet">

<!-- plugin: owl carousel  -->
<link href="{{ asset('public/plugins/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
<link href="{{ asset('public/plugins/owlcarousel/assets/owl.theme.default.css') }}" rel="stylesheet">
<script src="{{ asset('public/plugins/owlcarousel/owl.carousel.min.js') }}"></script>

<!-- custom style -->
<link href="{{ asset('public/css/ui.css') }}" rel="stylesheet" type="text/css"/>
<link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)" />

<link rel="shortcut icon" href="{{ asset('favicon.png') }}" type="image/png">

<link rel="manifest" href="{{ asset('manifest.json') }}">


<style>
	.put-on-hover:hover
	{
		background: #f1da96;
	}

	.put-on-hover:hover > a
	{
		color: #fff!important;
	}

	.button_8wWYA
	{
		color: #212529;
    background-color: #d39e00;
    border-color: #c69500;
	}

	.pace {
		-webkit-pointer-events: none;
		pointer-events: none;

		-webkit-user-select: none;
		-moz-user-select: none;
		user-select: none;
	}

	.pace-inactive {
		display: none;
	}

	.pace .pace-progress {
		background: #FEBF37;
		position: fixed;
		z-index: 2000;
		top: 0;
		right: 100%;
		width: 100%;
		height: 2px;
	}

	.page-item.active > .page-link
	{
		color: #212529;
    background-color: #d39e00;
    border-color: #c69500;
	}

	.page-link
	{
		color: #212529;
	}
	
	.card-product:hover
	{
		-webkit-box-shadow: 4px 6px 5px 0px rgba(0,0,0,0.72);
		-moz-box-shadow: 4px 6px 5px 0px rgba(0,0,0,0.72);
		box-shadow: 4px 6px 5px 0px rgba(0,0,0,0.72);
	}
</style>
<!-- custom javascript -->
<script src="{{ asset('public/js/script.js') }}" type="text/javascript"></script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-140088830-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-140088830-1');
</script>


</head>
<body>

	<input class="" type="hidden" name="base_url" id="base_url" value="{{ asset('/') }}" />
	<input class="" type="hidden" name="current_url" id="current_url" value="{{url()->current()}}" />

<header class="section-header">


<nav class="navbar navbar-expand-lg navbar-light " style="background-color: #2A2B30;">
  <div class="container">
			<a class="navbar-brand" href="{{ route('home_index') }}">
					<img class="logo" src="{{ asset('public/images/wholesales_white_noborder.png')}}" style="max-height: 42px!important;" alt="Whole Sale" title="alibaba e-commerce html css theme"></a>

    <button class="navbar-toggler d-none" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarTop">
      <ul class="navbar-nav mr-auto">       
				<!--<li class="nav-item dropdown">
				<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="color: #fff;">   Community </a>
							<ul class="dropdown-menu">
					<li><a class="dropdown-item" href="{{ route('help_index') }}">Help Center</a></li>
					<li><a class="dropdown-item" href="#">Submit a Dispute </a></li>
					<li><a class="dropdown-item" href="#">For Suppliers </a></li>
							</ul>
					</li>-->
      </ul>
      <ul class="navbar-nav">
				<li class="nav-item">
					<!--<a href="#" class="nav-link" >-->
					<img src="{{ asset('reroyaltrading_logo_200px-white.png') }}" style="max-height: 60px;">
					<!--</a>-->
				</li>
		
      </ul> <!-- navbar-nav.// -->
    </div> <!-- collapse.// -->
  </div>
</nav>

<section class="header-main shadow-sm">
	<div class="container">
<div class="row-sm align-items-center">
	<div class="col-lg-4-24 col-sm-3">
	<div class="category-wrap dropdown py-1">
		<button type="button" class="btn btn-light  dropdown-toggle" data-toggle="dropdown" ><i class="fa fa-bars"></i> Brands</button>
		<div class="dropdown-menu">
			@foreach ($categories as $category)
				<a class="dropdown-item" href="{{ url('shopping/category/'.($category->route != null ? $category->route : $category->id).'/products.html') }}">{{ $category->name }}</a>
			@endforeach
		</div>
	</div> 
	</div>
	<div class="col-lg-11-24 col-sm-8">
		<form action="{{ route('home_index') }}" method="GET" class="py-1">
				<div class="input-group w-100">
					<!--<select class="custom-select"  name="type">
						@foreach ($types as $item)
							<option value="{{ $item->id }}">{{ $item->name}}</option>
						@endforeach
						
					</select>-->
				<input type="text" class="form-control" value="{{ isset($term) ? $term : '' }}" name="term" style="width:50%;" placeholder="Search">
				    <div class="input-group-append">
				      <button class="btn btn-warning" type="submit">
				        <i class="fa fa-search"></i> Search 
				      </button>
				    </div>
			    </div>
			</form> <!-- search-wrap .end// -->
	</div> <!-- col.// -->
	<div class="col-lg-9-24 col-sm-12">
		<div class="widgets-wrap float-right row no-gutters py-1">
		
			@if(!Auth::guest())
			<div class="col-auto" ng-controller="FavoriteController">
				<div class="" ng-init="CheckIfProductIsOnWishList({{ $user->id }})"></div>
				<a href="#" ng-click="GetFavorites({{ $user->id }})" class="widget-header">
					<div class="icontext">
						<div class="icon-wrap"><i class="text-warning icon-sm  fa fa-heart"></i></div>
						<div class="text-wrap text-dark">
							<span class="small round badge badge-secondary" id="total_items_wish_list" name="total_items_wish_list">0</span>
							<div  class="d-none d-lg-block">Favorites</div>
						</div>
					</div>
				</a>

				<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" id="modalFavorites" name="modalFavorites">
						<div class="modal-dialog" role="document">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Wish list</h5>
									<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
									</button>
								</div>
								<div class="modal-body">
										<div class="row-sm">
												<div class="col-lg-4 col-sm-6 col-xs-6 col-md-4" ng-repeat="favorite in favorites">
													<figure class="card card-product">
														<div class="img-wrap" style="min-height: 100px;"> <img src="{{ url('storage')}}/<%favorite.image%>"></div>
														<figcaption class="info-wrap">
															<h6 class="title "><a href="{{ url('shopping/product'.'/') }}/<%favorite.code%>.html"><%favorite.item%></a></h6>
															
															<div class="price-wrap">
																<span class="price-new">$<%favorite.price%></span>
																<del class="price-old">$<%favorite.gross_price%></del>
															</div> <!-- price-wrap.// -->
															
														</figcaption>
														<button class="btn btn-secondary" ng-click="RemoveFromWishList(favorite.code, {{ $user->id }})">Remove</button>
													</figure> <!-- card // -->
												</div> <!-- col // -->
										</div>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-primary">Save changes</button>
									<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								</div>
							</div>
						</div>
					</div>
			</div>
			@endif

			<div class="col-auto">
					<a href="{{ route('checkout_index') }}" class="widget-header">
						<div class="icontext">
							<div class="icon-wrap"><i class="text-warning icon-sm fa fa-shopping-cart"></i></div>
							<div class="text-wrap text-dark">
								<span class="small round badge badge-secondary" id="total_items" name="total_items">{{ $total_items }}</span>
									<div class="d-none d-lg-block">My Cart</div>
							</div>
						</div>
					</a>
				</div> <!-- col.// -->

			<div class="col-auto">
					<div class="widget-header dropdown">
						<a href="#" data-toggle="dropdown" data-offset="20,10">
							
							<div class="icontext">
									
								<div class="icon-wrap"><i class="text-warning icon-sm fa fa-user"></i></div>
								<div class="text-wrap text-dark">
										
									@if(Auth::guest())
										Sign in <br>
										My account <i class="fa fa-caret-down"></i>
									@else
									<div class="d-none d-lg-block">
										My Account <br>
										{{ $user->name }}</div><i class="fa fa-caret-down"></i>
									@endif							
								</div>
							</div>
						</a>
						<div class="dropdown-menu" ng-controller="LoginController">
								@if(Auth::guest())
									<form class="px-4 py-3" ng-submit="DoLogin()">											
											<div class="form-group" ng-show="loginError">
													<div class="alert alert-warning" role="alert">Wrong user or password</div>
											</div>
									<div class="form-group">
										<label>Email address</label>
										<input type="email" class="form-control" ng-model="user.username" placeholder="email@example.com">
									</div>
									<div class="form-group">
										<label>Password</label>
										<input type="password" class="form-control" ng-model="user.password" placeholder="Password">
									</div>
									<button type="submit" class="btn btn-primary"><span ng-show="logging"><i class="fa fa-spin fa-spinner"></i></span> Sign in</button>
									</form>
									<hr class="dropdown-divider">
									<a class="dropdown-item" href="{{ route('register_index') }}">Have account? Sign up</a>
									<a class="dropdown-item" href="{{ route('recover_index') }}">Forgot password?</a>
								@else
									<ul class="list-group">
									<li class="put-on-hover list-group-item list-group-flush" style="border: none;"><a style="color: #212529;" href="{{ route('account_index') }}">Account</a></li>
										@if($user->ic_admin)
											<li class="put-on-hover list-group-item list-group-flush" style="border: none;"><a style="color: #212529;" href="{{ route('admin_console') }}">Console</a></li>
										@endif
											<li class="put-on-hover list-group-item list-group-flush" style="border: none;"><a style="color: #212529;" href="{{ route('auth_get_logout') }}">Logout</a></li>
									</ul>
								@endif
						</div> <!--  dropdown-menu .// -->
					</div>  <!-- widget-header .// -->
					</div> <!-- col.// -->
		</div> <!-- widgets-wrap.// row.// -->
	</div> <!-- col.// -->
</div> <!-- row.// -->
	</div> <!-- container.// -->
</section> <!-- header-main .// -->
</header> <!-- section-header.// -->


@yield('content')

<section class="section-subscribe bg-secondary padding-y-lg" ng-controller="MailMarketingController">
	<div class="container">
	
	<p class="pb-2 text-center white">Delivering the latest product trends and industry news straight to your inbox</p>
	
	<div class="row justify-content-md-center">
		<div class="col-lg-4 col-sm-6">
	<form class="row-sm form-noborder" ng-submit="RegisterNewsLetter()">
			<div class="col-8">
			<input class="form-control" ng-model="marketing.email" placeholder="Your Email" type="email">
			</div> <!-- col.// -->
			<div class="col-4">
			<button type="submit" class="btn btn-block btn-warning"> <i class="fa fa-envelope" ng-hide="sending_mail"></i> <i ng-show="sending_mail" class="fa fa-spin fa-spinner"></i> Subscribe </button>
			</div> <!-- col.// -->
	</form>
	<small class="form-text text-white-50">We’ll never share your email address with a third-party. </small>
		</div> <!-- col-md-6.// -->
	</div>
		
	
	</div> <!-- container // -->
	</section>

<footer class="section-footer bg-secondary" style="background-color: #2A2B30!important;">
	<div class="container">
		<section class="footer-top padding-top">
			<div class="row">
				<aside class="col-sm-4 col-md-4 white">
					<h5 class="title">Customer Services</h5>
					<ul class="list-unstyled">
						<!--<li> <a href="#">Help center</a></li>-->
						<li> <a href="{{ route('refund_index') }}">Money refund</a></li>
						<li> <a href="{{ route('privacy_policy') }}">Terms and Policy</a></li>
					</ul>
				</aside>
				<aside class="col-sm-4  col-md-4 white">
					<h5 class="title">My Account</h5>
					<ul class="list-unstyled">
						<li> <a href="{{ route('login') }}"> User Login </a></li>
						<li> <a href="{{ route('register_index') }}"> User register </a></li>
						<li> <a href="{{ route('account_index') }}"> Account Setting </a></li>
					</ul>
				</aside>
				<aside class="col-sm-4">
					<article class="white">
						
						<h5 class="title">Contacts</h5>
						
						<p>
							<strong>Support: </strong> +1 613 5182802 <br> 
						  <strong>Services:</strong> +1 416 7240877
						</p>

						 <div class="btn-group white">
						    <a class="btn btn-facebook" title="Facebook" target="_blank" href="https://www.facebook.com/reroyaltrading/"><i class="fab fa-facebook-f  fa-fw"></i></a>
						    <a class="btn btn-instagram" title="Instagram" target="_blank" href="https://www.instagram.com/re_royaltrading/"><i class="fab fa-instagram  fa-fw"></i></a>
						</div>
					</article>
				</aside>
			</div> <!-- row.// -->
			<br> 
		</section>
		<section class="footer-bottom row border-top-white">
				<div class="col-sm-6"> 
								<p class="text-white-50"> Made with <i class="fa fa-heart"></i> by <a href="" class="text-white-50">RE Apps</a>. Copyright &copy {{ date('Y') }} <a href="https://reroyaltrading.ca" class="text-white-50">R.E. RoyalTrading Inc</a></p>
				</div>
				<div class="col-sm-6 text-right">
						<img src="{{ asset('public/images/wholesales_white.png') }}" style="max-height: 40px;">
				</div>
		</section> <!-- //footer-top -->
		
	</div><!-- //container -->
</footer>

		
<!-- ========================= FOOTER END // ========================= -->
<script src="{{ asset('public/js/callus.js') }}"></script>

<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
<script src="{{ asset('public/js/bootstrap-notify.min.js') }}"></script>
<script src="{{ asset('public/js/pace.min.js') }}"></script>
<script src="{{ asset('public/plugins/dropzone/dropzone.js') }}"></script>
<script src="{{ asset('public/js/scope.js') }}"></script>
<script src="{{ asset('public/controller/ProductController.js') }}"></script>
<script src="{{ asset('public/controller/FavoriteController.js') }}"></script>
<script src="{{ asset('public/controller/LoginController.js') }}"></script>
<script src="{{ asset('public/controller/MailMarketingController.js') }}"></script>
<script src="{{ asset('public/controller/'.(isset($controller) ? $controller : 'HomeController').'.js') }}"></script>

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