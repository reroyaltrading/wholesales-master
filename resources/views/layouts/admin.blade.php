<!DOCTYPE html>
<html lang="en"  ng-app="WholeSale">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <title>WholeSales - Official RE RoyalTrading Retailer</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}" />

    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('public/ample/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- animation CSS -->
    <link href="{{ asset('public/ample/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    
    <link href="{{ asset('public/ample/css/style.css') }}" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('public/ample/css/colors/default.css') }}" id="theme" rel="stylesheet">

    <link href="{{ asset('public/plugins/dropzone/dropzone.css') }}"  rel="stylesheet" type="text/css"/>

    <link rel="stylesheet" href="//cdn.materialdesignicons.com/3.5.95/css/materialdesignicons.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- 3CX -->
    <script src="{{ asset('public/js/callus.js') }}"></script>
<style>
    .dropdown, .dropup {
    position: relative;
}

    .btn-project  
    {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #2f323e;
    }

    .btn-project-secondary, .btn-project-secondary:hover, .btn-project-secondary:focus
    {
        background-color: #2f323e;
        border-color: #2f323e;
        color: #ffc107;
    }

    #side-menu > li > a.active 
    {
        border-left: 3px solid #ffc107;
    }

    .image-display
    {
        border-radius: 20px;
        overflow: hidden;
        width: 120px;
        height: 120px;
        position: relative;
        display: block;
        z-index: 10;
    }

    .fill {
        display: flex;
        justify-content: center;
        align-items: center;
        overflow: hidden
    }
    .fill img {
        flex-shrink: 0;
        min-width: 100%;
        min-height: 100%
    }

    #callus{
        --call-us-form-header-background: #007bc7;
        --call-us-header-text-color: #ffffff;
        position: fixed;
        bottom: 20px;
        right: 6px;
    } 

    .note-codable
    {
        display: none!important;
    }

    .note-insert
{
	display: none!important;
}
    .note-editable
    {
        height: 200px!important;
        height: none!important;
        overflow-y: scroll;
        position:relative;
        height: 100px;
        resize: none;
    }


    .note-color-btn
    {
        border: 1px solid #e4e7ea;
        background: #e4e7ea;
        border-radius: 3px;
        padding: 5px 5px;
        font-size: 12px;
        line-height: 1.5;
    }

    .btn-default
    {
        color: #ffffff;
        background-color: #323232;
    }

    #tblResponsiveOrders
	{
		overflow: inherit;
	}

    .pagination > .active > a, .pagination > .active > a:focus, .pagination > .active > a:hover, .pagination > .active > span, .pagination > .active > span:focus, .pagination > .active > span:hover
    {
        background-color: #ffc107;
        border-color: #ffc107;
        color: #323232;
    }

    .devider {
        border-top: 1px solid #54667a;
        opacity: .1;
    }
</style>
</head>

<body class="fix-header">
    <input class="" type="hidden" name="base_url" id="base_url" value="{{ asset('/') }}" />
	<input class="" type="hidden" name="current_url" id="current_url" value="{{url()->current()}}" />
    <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0 ">
            <div class="navbar-header"  style="background-color: #323232;">
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light"><i class="mdi mdi-menu"></i></a></li>
                    <li class="hidden-xs hidden-sm">
                        <a href="{{ route('home_index') }}"><img src="{{ asset('public/images/wholesales_white.png') }}"  style="max-height: 60px;"/></a>
                    </li>
                </ul>
                <!-- /Logo -->
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li>
                    <form role="search" action="{{ route('home_index') }}" method="GET" class="app-search hidden-sm hidden-xs m-r-10">
                            <input type="text" name="term" id="term" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                    </li>

                    <ul class="nav navbar-top-links navbar-right pull-right hidden-xs hidden-sm">
                            <!--<li>
                                <form role="search" class="app-search hidden-sm hidden-xs m-r-10">
                                    <input type="text" placeholder="Search..." class="form-control"> <a href=""><i class="fa fa-search"></i></a> </form>
                            </li>-->
                            <li class="dropdown">
                                <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="true"> <img src="{{ asset('public/images/default_user.png') }}" alt="user-img" class="img-circle" width="36"><b class="hidden-xs">{{ $user->name }}</b><span class="caret"></span> </a>
                                <ul class="dropdown-menu dropdown-user animated flipInY">
                                    <li class="active">
                                        <div class="dw-user-box in">
                                            <div class="u-img"><img src="{{ asset('public/images/default_user.png') }}" alt="user"></div>
                                            <div class="u-text">
                                                <h4>{{ $user->name }}</h4>
                                            <p class="text-muted">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </li>
                                    <li><a href="{{ route('auth_get_logout') }}"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                                <!-- /.dropdown-user -->
                            </li>
                        </ul>
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav slimscrollsidebar">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-close ti-menu"></i></span> <span class="hide-menu">Navigation</span></h3>
                </div>
                <div class="center p-20 hidden-xs hidden-sm" style="padding: 80px 0 0!important; margin-right: 30px; margin-left: 30px;">
                    <a href="{{ route('home_index') }}" class="btn btn-project  btn-block waves-effect waves-light">Back to Shop</a>
                </div>
                <ul class="nav" id="side-menu">
                    <li style="padding: 20px 0 0!important;">
                        <a href="{{ route('admin_console') }}" class="waves-effect"><i class="fa fa-clock-o fa-fw" aria-hidden="true"></i>Dashboard</a>
                    </li>
                    <li>
                        <a href="{{ route('products_index_console') }}" class="waves-effect"><i class="fa fa-product-hunt fa-fw" aria-hidden="true"></i>Products</a>
                    </li>
                    <li>
                        <a href="{{ route('banner_index') }}" class="waves-effect"><i class="fa fa-image fa-fw" aria-hidden="true"></i>Banners</a>
                    </li>
                    <li>
                        <a href="{{ route('users_index') }}" class="waves-effect"><i class="fa fa-user fa-fw" aria-hidden="true"></i>Users</a>
                    </li>
                    <div class="devider"></div>
                    <li>
                        <a href="{{ route('suppliers_index') }}" class="waves-effect"><i class="fa fa-truck fa-fw" aria-hidden="true"></i>Suppliers</a>
                    </li>
                    
                    <li>
                        <a href="{{ route('orders_index') }}" class="waves-effect"><i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Orders</a>
                    </li>
                    <li>
                        <a href="{{ route('purchase_order_statuses_index') }}" class="waves-effect"><i class="fa fa-map-marker fa-fw" aria-hidden="true"></i>Orders Statuses</a>
                    </li>
                    <div class="devider"></div>
                    <li>
                        <a href="{{ route('news_index') }}" class="waves-effect"><i class="fa fa-envelope fa-fw" aria-hidden="true"></i>Newsletter</a>
                    </li>
                    <li>
                        <a href="{{ route('contact_index') }}" class="waves-effect"><i class="fa fa-paper-plane fa-fw" aria-hidden="true"></i>Contacts</a>
                    </li>
                    <div class="devider"></div>
                    <li>
                        <a href="{{ route('brand_index') }}" class="waves-effect"><i class="fa fa-copyright fa-fw" aria-hidden="true"></i>Brands</a>
                    </li>
                    <li>
                        <a href="{{ route('category_index') }}" class="waves-effect"><i class="fa fa-list-alt fa-fw" aria-hidden="true"></i>Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('discount_index') }}" class="waves-effect"><i class="fa fa-dollar fa-fw" aria-hidden="true"></i>Discounts</a>
                    </li>
                    <div class="devider"></div>

                    @if(isset($items))
                        <div class="devider"></div>
                        @foreach($items as $item)
                        <li>
                            <a href="{{ url('admin/purchases/orders/status/'.$item->id.'.html?name='.$item->name) }}" class="waves-effect">
                                <i class="fa fa-circle fa-fw" aria-hidden="true"></i>{{ $item->name }}
                                @if($item->total)
                                    <span class="badge badge-info badge-pill ml-auto mr-3 font-medium px-2 py-1 pull-right">{{ $item->total }}</span>
                                @endif
                            </a>
                        </li>
                        @endforeach
                        <div class="devider"></div>
                    @endif
                    <li>
                        <a href="{{ route('auth_get_logout') }}" class="waves-effect"><i class="fa fa fa-power-off fa-fw" aria-hidden="true"></i>Logout</a>
                    </li>
                    
                </ul>
                
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page Content -->
        <!-- ============================================================== -->
        <div id="page-wrapper">
            @yield('content')
            <footer class="footer text-center"> 2019 &copy; RE Royal Tranding </footer>
        </div>
        <!-- ============================================================== -->
        <!-- End Page Content -->
        <!-- ============================================================== -->
    </div>

    <!-- /#wrapper -->
    <!-- jQuery -->
    <script src="{{ asset('public/ample/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('public/ample/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('public/ample/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('public/ample/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('public/ample/js/waves.js') }}"></script>
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('public/ample/js/custom.min.js') }}"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.5.6/angular.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="{{ asset('public/js/bootstrap-notify.min.js') }}"></script>
    
    @yield('pagescript')

    <script src="{{ asset('public/plugins/dropzone/dropzone.js') }}"></script>
    <script src="{{ asset('public/js/scope.js') }}"></script>
    <script src="{{ asset('public/controller/FavoriteController.js') }}"></script>
    <script src="{{ asset('public/controller/'.(isset($controller) ? $controller : 'HomeController').'.js') }}"></script>
    

</body>

</html>
