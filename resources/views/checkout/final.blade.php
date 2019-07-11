
@extends('layouts.same')

@section('content')

<section class="bg-light" style="padding-top: 45px; padding-bottom: 45px;">
    <div class="container" ng-controller="CheckoutController">
      

      <div class="row">
        <div class="col-md-4 order-md-2 mb-4">
          <h4 class="d-flex justify-content-between align-items-center mb-3">
            <span class="text-muted">Your cart</span>
            <span class="badge badge-secondary badge-pill">{{ count($products) }}</span>
          </h4>
          <ul class="list-group mb-3">

          <?php		
          foreach ($products as $product){
              $item_price = $product->sub_price;
		      ?>
            <li class="list-group-item d-flex justify-content-between lh-condensed">
              <div>
                <h6 class="my-0">{{ $product->item }}</h6>
                <small class="text-muted">{{ $product->sub_price }}</small>
              </div>
              <span class="text-muted">{{ $product->price }}</span>
            </li>
          <?php  } ?>
            <li class="list-group-item d-flex justify-content-between">
              <span>Total (CAD)</span>
              <strong>{{ $total }}</strong>
            </li>
          </ul>

          <!--<form class="card p-2" ng-submit="SendPromoCode()">
            <div class="input-group">
              <input type="text" class="form-control" placeholder="Promo code">
              <div class="input-group-append">
                <button type="submit" class="btn btn-secondary">Redeem</button>
              </div>
            </div>
          </form>-->
        </div>
        <div class="col-md-8 order-md-1">
        <div class="card">
	        <div class="card-body">
          
          <h4 class="mb-3">Billing address</h4>
          <form ng-submit="SaveOrder()">
          <div class="mb-3">
              <label for="phone_number">Phone Number</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="color: #ff0000;">*</span>
                </div>
                    <input type="text" class="form-control" id="phone_number" value="{{ $user->phone }}" placeholder="Phone Number" required="required">
                <div class="invalid-feedback" style="width: 100%;">
                  Your Name company is required.
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label for="firstName">First name</label>
                <input type="text" class="form-control" value="{{ $user->name }}" id="first_name" placeholder="" value="" required="required">
                <div class="invalid-feedback">
                  Valid first name is required.
                </div>
              </div>
              <div class="col-md-6 mb-3">
                <label for="lastName">Last name</label>
                <input type="text" class="form-control" id="last_name" placeholder="" value="{{ $user->last_name }}" required="required">
                <div class="invalid-feedback">
                  Valid last name is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="companyname">Name company</label>
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text" style="color: #ff0000;">*</span>
                </div>
                <input type="text" class="form-control" id="company_name" value="{{ empty($company) ? '' : $company->name }}" placeholder="Name Company" required="required">
                <div class="invalid-feedback" style="width: 100%;">
                  Your Name company is required.
                </div>
              </div>
            </div>

            <div class="mb-3">
              <label for="email">Email <span class="text-muted">(Optional)</span></label>
              <input type="email" class="form-control" id="email" value="{{ $user->email }}" placeholder="you@yourcompanydomain.com" required="required">
              <div class="invalid-feedback" style="width: 100%;">
                Your Email is required.
              </div>
            </div>

            <div class="mb-3">
              <label for="address">Address</label>
              <input type="text" class="form-control" id="address" value="{{ empty($company) ? '' : $company->address }}" placeholder="1234 Main St" required="required">
              <div class="invalid-feedback">
                Please enter your shipping address.
              </div>
            </div>

            <div class="mb-3">
              <label for="address2">Address 2 <span class="text-muted">(Optional)</span></label>
              <input type="text" class="form-control" id="address2" placeholder="Apartment or suite">
            </div>

            <div class="row">
              <div class="col-md-5 mb-3">
                <label for="country">Country</label>
                <select class="custom-select d-block w-100" id="country" required="">
                  
                </select>
                <div class="invalid-feedback">
                  Please select a valid country.
                </div>
              </div>
              <div class="col-md-4 mb-3">
                <label for="state">State</label>
                <select class="custom-select d-block w-100" ng-model="purchase.state" id="state" required="">
                  <option value="">Choose...</option>
                  <option>California</option>
                  <option>Other</option>
                </select>
                <div class="invalid-feedback">
                  Please provide a valid state.
                </div>
              </div>
              <div class="col-md-3 mb-3">
                <label for="zip">Zip Code</label>
                <input type="text" class="form-control" id="zip_code" value="{{ empty($company) ? '' : $company->zip_code }}" placeholder="" required="">
                <div class="invalid-feedback">
                  Zip code required.
                </div>
              </div>
            </div>
            <hr class="mb-4">
            <div class="custom-control custom-checkbox">
              <input type="checkbox" ng-true-value="1" ng-false-value="0" class="custom-control-input" id="same_address">
              <label class="custom-control-label" for="same-address">Shipping address is the same as my billing address</label>
            </div>
            <div class="custom-control custom-checkbox">
              <input type="checkbox" ng-true-value="1" ng-false-value="0" class="custom-control-input" id="receive_quote_monthly">
              <label class="custom-control-label" for="save-info">I want to receive a quote about other products monthly</label>
            </div>
            <hr class="mb-4">

            <h4 class="mb-3">Payment</h4>

            <div class="d-block my-3">
              <div class="custom-control custom-radio">
                <input id="credit" name="paymentMethod" ng-true-value="1" ng-false-value="0" type="radio" id="payment_credit_card"  class="custom-control-input" checked="" required="">
                <label class="custom-control-label" for="credit">Credit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="debit" name="paymentMethod" ng-true-value="1" ng-false-value="0" type="radio"  id="payment_debit_card" class="custom-control-input" required="">
                <label class="custom-control-label" for="debit">Debit card</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" ng-true-value="1" ng-false-value="0" type="radio"  id="payment_paypal" class="custom-control-input" required="">
                <label class="custom-control-label" for="paypal">PayPal</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" ng-true-value="1" ng-false-value="0" type="radio"  id="payment_cash" class="custom-control-input" required="">
                <label class="custom-control-label" for="paypal">Cash</label>
              </div>
              <div class="custom-control custom-radio">
                <input id="paypal" name="paymentMethod" ng-true-value="1" ng-false-value="0" type="radio" class="custom-control-input"  id="payment_other" required="">
                <label class="custom-control-label" for="paypal">Other</label>
              </div>
            </div>
            
            <hr class="mb-4">
            <button class="btn btn-primary btn-lg btn-block" ng-click="SaveOrder()" >Continue to checkout</button>
          </form>
        </div>
        </div>
        </div>
      </div>

    
    </div>
</section>

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="{{ asset('public/index_files/jquery-3.3.1.slim.min.js') }}" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="{{ asset('public/index_files/popper.min.js') }}"></script>
    <script src="{{ asset('public/index_files/bootstrap.min.js') }}"></script>
    <script src="{{ asset('public/index_files/holder.min.js') }}"></script>
    

    @endsection