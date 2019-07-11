@extends('layouts.home')

@section('content')

<section class="section-content bg padding-y-sm" ng-controller="HomeController">
    <div class="container">


      @if(count($banners) > 0)
        <div class="card margin-y-sm">
            <div class="card-body">
          <div class="row row-sm">
          
            <div class="col-md-12">
          
          <!-- ================= main slide ================= -->
          <div class="owl-init slider-main owl-carousel" data-items="1" data-nav="true" data-dots="false">
            @foreach ($banners as $banner)
              <div class="item-slide">
                <a href="{{$banner->url_link}}">
                <img src="{{ asset('storage/'.$banner->location) }}"></a>
              </div>
            @endforeach
          </div>
          <!-- ============== main slidesow .end // ============= -->
          
            </div> <!-- col.// -->
          
          </div> <!-- row.// -->
            </div> <!-- card-body .// -->
          </div> <!-- card.// -->
      @endif   
       
          
    <div class="card "  style="margin-top: 20px;">
        <div class="card-body">
    <div class="row">
        <div class="col-md-3-24"> <strong>Your are here:</strong> </div> <!-- col.// -->
        <nav class="col-md-18-24"> 
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Home</a></li>
            @if(isset($category))
              <li class="breadcrumb-item"><a href="{{ url('category/'.$category->route.'/products.html') }}">{{ $category->name }}</a></li>            
              <li class="breadcrumb-item active" aria-current="page">Items</li>
            @endif
        </ol>  
        </nav> <!-- col.// -->
        <!--<div class="col-md-3-24 text-right"> 
         <a href="#" data-toggle="tooltip" title="List view"> <i class="fa fa-bars"></i></a>
         <a href="#" data-toggle="tooltip" title="Grid view"> <i class="fa fa-th"></i></a>
        </div>--> <!-- col.// -->
    </div> <!-- row.// -->
    <hr>
    <div class="row">
        <div class="col-md-3-24"> <strong>Filter by:</strong> </div> <!-- col.// -->
        <div class="col-md-21-24"> 
            <ul class="list-inline">
             
              <li class="list-inline-item dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color: #212529;">  Order by </a>
                <div class="dropdown-menu p-3" style="max-width:400px;">	
                  <label class="form-check">
                    <a href="{{ route('home_index').'?order_price=lower'.
                           (isset($term) ? '&term='.$term : '').
                           (isset($price_min) ? '&price_min='.$price_min : '').
                           (isset($price_max) ? '&price_max='.$price_max : '') }}">
                       Lower Price
                    </a>
                  </label>
                  <label class="form-check">
                      <a href="#">
                        Higher Price
                    </a>
                  </label>
                  <label class="form-check">
                      <a href="#">
                        Best sellers
                    </a>
                  </label>
                </div> 
              </li>
                          
              <li class="list-inline-item">
                <form class="form-inline" action="{{ route('home_index')}}">
                      <label class="mr-2">Price</label>
                    <input class="form-control form-control-sm"  value="{{ isset($price_min) ? $price_min : '' }}"name="price_min" id="price_min" placeholder="Min" type="number">
                        <span class="px-2"> - </span>
                <input class="form-control form-control-sm" value="{{ isset($price_max) ? $price_max : '' }}" name="price_max" id="price_max" placeholder="Max" type="number">
                    <button type="submit" class="btn btn-sm btn-warning ml-2">Ok</button>
                  </form>
              </li>
            </ul>
        </div> <!-- col.// -->
    </div> <!-- row.// -->
        </div> <!-- card-body .// -->
    </div> <!-- card.// -->
    
    @if(isset($has_search) ? $has_search : false)
      <div class="padding-y-sm">
        <span>{{ $total_products }} results found</span>	
      </div>
    @endif
    
   
       
    <div class="row-sm padding-y-sm">

    @foreach ($products as $product)
    <div class="col-md-3 col-sm-6">
      <a href="{{ url('/shopping/product'.'/'. (empty($product->route) ? $product->code : $product->route)) }}.html">
        <figure class="card card-product">
            <div class="img-wrap"> <img src="{{ !empty($product->image) ? url('storage/'.$product->image) : url('public/images/items/no-product-image.png') }}"></div>
            <figcaption class="info-wrap">
                <a href="{{ url('/shopping/product'.'/'. (empty($product->route) ? $product->code : $product->route)) }}.html" class="title">{{ $product->item }}</a>
                <div class="price-wrap">
                    @if(!Auth::guest())
                      <!--<button href="#" ng-click="OrderProduct(1, {{ $product->code }})" class="btn btn-primary btn-sm float-right"> Order </button>-->
                    @endif
                    <span class="price-new">CAD ${{ $product->price }}</span>
                    <del class="price-old">CAD ${{ $product->price }}</del>
                </div> <!-- price-wrap.// -->
            </figcaption>
        </figure> <!-- card // -->
      </a>
    </div> <!-- col // -->
    @endforeach
    </div> <!-- row.// -->

    @if($max_page > 0)
      <div class="row">
        <div class="col-md-12">
          <nav aria-label="Page navigation example">
              <ul class="pagination justify-content-center">
                <li class="page-item {{ $page > 1 ? 'enabled': 'disabled' }}">
                  <a class="page-link" disabled="disabled" href="{{ (isset($is_category) ? url('/shopping/category'.'/'.$category->route.'/products.html') : route('home_index')).'?page='.($page-1).'&term='.$term }}" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only">Previous</span>
                  </a>
                </li>

                @for($i = $min_page; $i <= $max_page; $i++)
                  <li class="page-item {{ $i == $page ? 'active' : '' }}"><a class="page-link" href="{{ (isset($is_category) ? url('/shopping/category'.'/'.$category->route.'/products.html') : route('home_index')).'?page='.($i).'&term='.$term }}">{{ $i }}</a></li>
                @endfor
                <li class="page-item {{ $page < $total_pages ? 'enabled': 'disabled' }}">
                  <a class="page-link" href="{{ (isset($is_category) ? url('/shopping/category'.'/'.$category->route.'/products.html') : route('home_index')).'?page='.($page+1).'&term='.$term }}" aria-label="Next">
                  
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only">Next</span>
                  </a>
                </li>
              </ul>
            </nav>
      </div>
      </div>
      @endif

    
    </div><!-- container // -->
    </section>

@endsection