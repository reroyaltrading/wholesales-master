@extends('layouts.same')

@section('content')

 <!-- ========================= SECTION CONTENT ========================= -->
 <section class="section-content bg padding-y border-top" ng-controller="ProductController">
        <div class="container" ng-init="LoadShoppingCart()"> 
        
        <div class="row" ng-show="products.length > 0">
            <main class="col-sm-9">
        
        <div class="card">
        <table class="table table-hover shopping-cart-wrap">
        <thead class="text-muted">
        <tr>
          <th scope="col">Product</th>
          <th scope="col" width="120">Quantity</th>
          <th scope="col" width="120">Price</th>
          <th scope="col" class="text-right d-none d-sm-block" width="200">Action</th>
        </tr>
        </thead>
        <tbody>

                       
            
        <tr ng-repeat="product in products">  
            <td>
        <figure class="media">
            <div class="img-wrap"><img src="{{ url('storage') }}/<% product.image %>" class="img-thumbnail img-sm"></div>
            <figcaption class="media-body d-none d-sm-block">
                <h6 class="title text-truncate"><% product.item %></h6>
                <dl class="dlist-inline small ">
                  <dt>Size: </dt>
                  <dd>XXL</dd>
                </dl>
                <dl class="dlist-inline small">
                  <dt>Color: </dt>
                  <dd>Orange color</dd>
                </dl>
            </figcaption>
        </figure> 
            </td>
            <td> 
                 <input class="form-control" type="number" ng-model="product.quantity" ng-change="UpdateOn(product)"/>
            </td>
            <td class="d-none d-sm-block"> 
                <div class="price-wrap"> 
                    <var class="price">CAD <% product.sub_price %></var> 
                    <small class="text-muted">(CAD <% product.price %> each)</small> 
                </div> <!-- price-wrap .// -->
            </td>
            <td class="text-right"> 
            
            <a href="#" ng-click="RemoveFromShoppingCart(product.code)" class="btn btn-outline-danger"><i class="fa fa-times"></i> </a>
            </td>
        </tr>

        <tr>
            <td colspan="4">
                <div class="pull-right">
                    <a href="#" style="float: right;" ng-click="SaveCart()" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Save Cart</a>
                </div>
            </td>
        </tr>
       
        </tbody>
        </table>
        </div> <!-- card.// -->
        
            </main> <!-- col.// -->
            <aside class="col-sm-3">
       
        <dl class="dlist-align">
          <dt>Total price: </dt>
          <dd class="text-right">CAD <% total_price %></dd>
        </dl>
        <dl class="dlist-align">
          <dt>Discount:</dt>
          <dd class="text-right">CAD 0</dd>
        </dl>
        <dl class="dlist-align h4">
          <dt>Total:</dt>
          <dd class="text-right"><strong>CAD <% total_price %></strong></dd>
        </dl>
        <hr>
        <figure class="itemside mb-3">
            <!-- {{ route('finalize_checkout') }}-->
            <a href="#" class="btn btn-success btn-block" ng-click="ProceedPurchase()"><span ng-show="loading_purchase"><i class="fa fa-spin fa-spinner"></i></span> Proceed</a>
        </figure>
        <!--<figure class="itemside mb-3">
            <a href="{{ route('home_index') }}" class="btn btn-primary  btn-block">Cancel</a>
        </figure>-->
        
            </aside> <!-- col.// -->
        </div>
        

        <div class="row"  ng-show="products.length == 0">
            <div class="col-md-12">
                <section class="section-name bg padding-y  text-center">
                        <div class="container">
                        <h4>No product found on your chart</h4>
                        <p>We couldn't found any product on your cart, keep browsing!</p>
                        </div><!-- container // -->
                </section>
            </div>
        </div>

        </div> <!-- container .//  -->
        </section>
        <!-- ========================= SECTION CONTENT END// ========================= -->

@endsection