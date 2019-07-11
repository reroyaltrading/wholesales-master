<html lang="en" ng-app="WholeSale"><head>
        <meta charset="utf-8">
        <meta http-equiv="pragma" content="no-cache">
        <meta http-equiv="cache-control" content="max-age=604800">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="author" content="Bootstrap-ecommerce by Vosidiy">
        
        <title>WholeSales - Official RE RoyalTrading Retailer</title>

        <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />
        
        
        <!-- jQuery -->
        <script src="{{ asset('public/js/jquery-2.0.0.min.js') }}" type="text/javascript"></script>
        
        <!-- Bootstrap4 files-->
        <script src="{{ asset('public/js/bootstrap.bundle.min.js') }}" type="text/javascript"></script>
        <link href="{{ asset('public/css/bootstrap.css') }}" rel="stylesheet" type="text/css">
        
        <!-- Font awesome 5 -->
        <link href="{{ asset('public/fonts/fontawesome/css/fontawesome-all.min.css') }}" type="text/css" rel="stylesheet">
        
        <!-- custom style -->
        <link href="{{ asset('public/css/ui.css') }}" rel="stylesheet" type="text/css">
        <link href="{{ asset('public/css/responsive.css') }}" rel="stylesheet" media="only screen and (max-width: 1200px)">
        
        <!-- custom javascript -->
        <script src="{{ asset('public/js/script.js') }}" type="text/javascript"></script>
        
        <style>
            .btn-project-secondary, .btn-project-secondary:hover, .btn-project-secondary:focus {
                background-color: #2f323e;
                border-color: #2f323e;
                color: #ffc107;
            }
        </style>
        
        </head>
        <body style="">

                
                <nav class="navbar navbar-expand-lg navbar-light" style="background-color: #2A2B30;">
                        <div class="container">
                          <a class="navbar-brand" href="{{ route('home_index') }}">
                            <img class="logo" src="{{ asset('public/images/wholesales_white_noborder.png')}}" alt="Whole Sale" title="alibaba e-commerce html css theme"></a>
                          <button class="navbar-toggler d-none" type="button" data-toggle="collapse" data-target="#navbarTop" aria-controls="navbarTop" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                          </button>
                      
                          <div class="collapse navbar-collapse" id="navbarTop">
                            <ul class="navbar-nav mr-auto">
                              <!--<li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">   Sourcing </a>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Top  Suppliers</a></li>
                                      <li><a class="dropdown-item" href="#">Suppliers by Regions </a></li>
                                      <li><a class="dropdown-item" href="#">Online Retailer  </a></li>
                                  </ul>
                              </li>
                              <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">   Services </a>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Trade Assurance </a></li>
                                      <li><a class="dropdown-item" href="#">Arabic</a></li>
                                      <li><a class="dropdown-item" href="#">Logistics Service </a></li>
                                      <li><a class="dropdown-item" href="#">Membership Services</a></li>
                                  </ul>
                              </li>
                              <li class="nav-item dropdown"><a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown" style="color: #fff;">   Community </a>
                                  <ul class="dropdown-menu">
                                      <li><a class="dropdown-item" href="#">Help Center</a></li>
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

            	<input class="" type="hidden" name="base_url" id="base_url" value="{{ asset('/') }}" />
    <input class="" type="hidden" name="current_url" id="current_url" value="{{url()->current()}}" />
    
        <header class="section-header">
       
        <section class="header-main">
            <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-sm-4">
           
            </div>
            <div class="col-lg-6 col-sm-8">
                    <form action="{{ route('home_index') }}" class="search-wrap">
                        <div class="input-group w-100">
                            <input type="text" class="form-control" style="width:55%;" name="term" id="term" placeholder="Search">
                            
                            <div class="input-group-append">
                              <button class="btn btn-warning" type="submit">
                                <i class="fa fa-search"></i>
                              </button>
                            </div>
                        </div>
                    </form> <!-- search-wrap .end// -->
            </div> <!-- col.// -->
            <div class="col-lg-3 col-sm-12  d-none d-sm-block">
                    <a href="tel:+16135182802" class="widget-header float-md-right">
                        <div class="icontext">
                            <div class="icon-wrap" style="color: #212529;"><i class="flip-h fa-lg fa fa-phone"></i></div>
                            <div class="text-wrap">
                                <small style="color: #212529;">Phone</small>
                                <div style="color: #212529;">+1 613 5182802 </div>
                            </div>
                        </div>
                    </a>
            </div> <!-- col.// -->
        </div> <!-- row.// -->
            </div> <!-- container.// -->
        </section> <!-- header-main .// -->
        </header> <!-- section-header.// -->
        
        @yield('content')
        
               
        
        
        <!-- ========================= FOOTER ========================= -->
        <footer class="section-footer bg-secondary"  style="background-color: #2A2B30!important;">
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
                                <li> <a href="{{ route('home_index') }}"> User Login </a></li>
                                <li> <a href="{{ route('register_index') }}"> User register </a></li>
                                <li> <a href="{{ route('account_index') }}"> Account Setting </a></li>
                            </ul>
                        </aside>
                       
                        <aside class="col-sm-4">
                            <article class="white">
                                <h5 class="title">Contacts</h5>
                                <p>
                                    <strong>Customer Support: </strong>+1 613 5182802  <br> 
                                    <strong>Customer Services:</strong>+1 416 7240877
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
        
        <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="{{ asset('public/plugins/dropzone/dropzone.js') }}"></script>
        <script src="{{ asset('public/js/bootstrap-notify.min.js') }}"></script>
        <script src="{{ asset('public/js/scope.js') }}"></script>
        <script src="{{ asset('public/controller/ProductController.js') }}"></script>
        <script src="{{ asset('public/controller/'.(isset($controller) ? $controller : 'HomeController').'.js') }}"></script>
        
        </body></html>