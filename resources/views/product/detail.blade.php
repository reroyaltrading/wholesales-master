@extends('layouts.home')

@section('content')
    <!-- ========================= SECTION CONTENT ========================= -->
    <section class="section-content bg padding-y-sm" ng-controller="ProductController">
    <div class="container" ng-init="CheckIfProductIsOnWishList({{ $product->code }})">
    <nav class="mb-3">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="#">Home</a></li>
        @if(isset($category))
            <li class="breadcrumb-item"><a href="{{ url('/shopping/category/'.$category->route.'/products.html') }}">{{ $category->name }}</a></li>            
            <li class="breadcrumb-item active" aria-current="page">{{ $product->item }}</li>
        @endif
    </ol> 
    </nav>
    
    <div class="row">
    <div class="col-xl-10 offset-xl-1 col-md-12 col-sm-12">
    
    
    <main class="card">
        <div class="row no-gutters">
            <aside class="col-sm-6 border-right">
    <article class="gallery-wrap"> 
    <div class="img-big-wrap">
      <div> 
          <a id="imageSourceRef" href="{{ !empty($product->image) ? url('storage/'.$product->image) : url('public/images/items/no-product-image.png') }}" data-fancybox="">
          <img id="imageSource" src="{{ !empty($product->image) ? url('storage/'.$product->image) : url('public/images/items/no-product-image.png') }}"></a>
        </div>
    </div> <!-- slider-product.// -->
    @if(count($images) > 0)
        <div class="img-small-wrap">
            @foreach ($images as $item)
                <div class="item-gallery" ng-click="ChangeImageOfProduct('{{ url('storage/'.$item->location) }}')"> 
                    <img src="{{ url('storage/'.$item->location) }}">
                </div>
            @endforeach
        </div> <!-- slider-nav.// -->
    @endif
    </article> <!-- gallery-wrap .end// -->
            </aside>
            <aside class="col-sm-6">
    <article class="card-body">
    <!-- short-info-wrap -->
    <h3 class="title mb-3">{{ $product->item }}</h3>
    
    <div class="mb-3"> 
        <var class="price h3 text-warning"> 
            <span class="currency">CAD $</span><span class="num">{{ $product->price }}</span>
        </var> 
        <span>/per un.</span> 
    </div> <!-- price-detail-wrap .// -->
    <dl>
      <dt>Description</dt>
      <dd><p> {{ $product->description }} </p></dd>
    </dl>
    <dl class="row">
      <dt class="col-sm-3">Model#</dt>
      <dd class="col-sm-9">PX0000{{ $product->code }}</dd>
    
      <dt class="col-sm-3">Itens</dt>
      <dd class="col-sm-9">{{ $product->items_on_box }} </dd>
    
      <dt class="col-sm-3">Delivery</dt>
      <dd class="col-sm-9">Canada</dd>
    </dl>
    <!--<div class="rating-wrap">
    
        <ul class="rating-stars">
            <li style="width:80%" class="stars-active"> 
                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> 
            </li>
            <li>
                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> <i class="fa fa-star"></i> 
                <i class="fa fa-star"></i> 
            </li>
        </ul>
        <div class="label-rating">132 reviews</div>
        <div class="label-rating">154 orders </div>
    </div>  --><!-- rating-wrap.// -->
    <hr>
        <div class="row">
            <div class="col-sm-5">
                <dl class="dlist-inline">
                  <dt>Quantity: </dt>
                  <dd> 
                      <select  {{ Auth::guest() ? "disabled='disabled'" : '' }} class="form-control form-control-sm" style="width:70px;" id="selected_quantity">
                        @for($i = 1; $i <= 100; $i++)
                          <option {{ $i == 1 ? "selected=1" : '' }}>{{ $i }}</option>
                        @endfor
                      </select>
                  </dd>
                </dl>  <!-- item-property .// -->
            </div> <!-- col.// -->
            <!--<div class="col-sm-7">
                <dl class="dlist-inline">
                      <dt>Size: </dt>
                      <dd>
                          <label class="form-check form-check-inline">
                          <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
                          <span class="form-check-label">SM</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
                          <span class="form-check-label">MD</span>
                        </label>
                        <label class="form-check form-check-inline">
                          <input class="form-check-input" name="inlineRadioOptions" id="inlineRadio2" value="option2" type="radio">
                          <span class="form-check-label">XXL</span>
                        </label>
                      </dd>
                </dl>  tem-property .// -
            </div>  col.// -->
        </div> <!-- row.// -->
        <hr>
        
        <button style="margin: 4px;" ng-click="AddWishList({{ $product->code }})" {{ Auth::guest() ? "disabled='disabled'" : '' }} class="btn  btn-warning">
            <i class="fa fa-star"></i> <span id="wishlistcontent">{{ Auth::guest() ? "Login to add" : 'Add Wishlist' }} </span>
        </button>

        <button style="margin: 4px;" ng-click="AddProduct({{ $product->code }})" {{ Auth::guest() ? "disabled='disabled'" : '' }} class="btn  btn-warning"><i class="fa fa-shopping-cart"></i> {{ Auth::guest() ? "Login to order" : 'Order' }} </button>

    <a href="#" style="margin: 4px;" ng-click="OpenSuppierForm()" class="btn   btn-warning"> <i class="fa fa-envelope"></i> Contact Supplier </a>
    <!-- short-info-wrap .// -->
    </article> <!-- card-body.// -->
            </aside> <!-- col.// -->
        </div> <!-- row.// -->
    </main> <!-- card.// -->
    
    <!-- PRODUCT DETAIL -->
    @if(strlen($product->cold_description) > 0)
    <article class="card mt-3">
        <div class="card-body">
            <h4>Detail overview</h4>
            
            <p>{!! $product->cold_description !!}</p>
      
        </div> <!-- card-body.// -->
    </article> <!-- card.// -->
    @endif
    
    <header class="section-heading heading-line mt-3">
            <h4 class="title-section bg text-uppercase">You may also like</h4>
    </header>

    <div class="card">
            <div class="row no-gutters">
                <div class="col-md-3">
                
            <article href="#" class="card-banner h-100 bg2">
                <div class="card-body zoom-wrap" style="background-color: #EFEFEF;">
                    <h5 class="title">{{ $category->name }} </p>
                    <a href="{{ asset('/shopping/category/'.($category->route != null ? $category->route : $category->id).'/products.html') }}" class="btn btn-warning">
                           <span class="d-none d-lg-block"> Explore this category</span>
                           <span class="d-lg-none"> Explore</span>
                    </a>
                    <img src="{{ asset('public/images/background_bag.png') }}" height="200" class="img-bg zoom-in">
                </div>
            </article>
            
                </div> <!-- col.// -->
                <div class="col-md-9">
                    <ul class="row no-gutters border-cols">
                      @foreach ($products as $product)
                        <li class="col-6 col-md-3">
                            <a href="{{ url('/shopping/product'.'/'. (empty($product->route) ? $product->code : $product->route).'.html') }}" class="itembox"> 
                                <div class="card-body card-body border-top">
                                    
                                    <img class="img-sm img-responsive" src="{{ !empty($product->image) ? url('storage/'.$product->image) : url('public/images/items/no-product-image.png') }}">
                                    <p class="word-limit">{{ substr($product->item, 0, 30) }}</p>

                                    <p style="mt-3">
                                        <span class="price-new" style="color: #323232;">CAD ${{ $product->price }}</span> <del class="price-old">CAD ${{ $product->price }}</del>
                                    </p>
                                </div>
                            </a>
                                </li>
                      @endforeach
                    </ul>
                        </div> <!-- col.// -->
                    </div> <!-- row.// -->
                
            </div>

  
    <!-- PRODUCT DETAIL .// -->
    
    </div> <!-- col // -->
   
    </div> <!-- row.// -->
    
    
    
    </div><!-- container // -->


<!-- Modal -->
<form name="formSendContact" id="formSendContact" ng-submit="SendContactInfo()">
<div class="modal fade" id="modalSupplierContact" name="modalSupplierContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Contact Supplier</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Name</label>
                <input type="text" ng-model="contact.name" required="required" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
            </div>
              
            <div class="form-group">
                <label for="exampleInputEmail1">Email address</label>
                <input type="email" ng-model="contact.email" required="required" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Message</label>
                <textarea type="text" ng-model="contact.message" required="required" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter message">
                </textarea>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning"><span ng-show="sending_contact"><i class="fa fa-spin fa-spinner"></i>&nbsp;</span>Send message</button>
        </div>
      </div>
    </div>
  </div>
</form>
    
    </section>
    <!-- ========================= SECTION CONTENT .END// ========================= -->

    @endsection