@extends('layouts.same')

@section('content')

 <section class="section-pagetop bg-secondary">
    <div class="container clearfix">
        <h2 class="title-page">Lastest Orders</h2>
    
        <nav class="float-left">
        <ol class="breadcrumb text-white">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Home</a></li>
            <li class="breadcrumb-item active"><a href="{{ route('account_index') }}">Account</a></li>
        </ol>  
        </nav>
    </div>
    </section>

    <section class="section-content bg padding-y" ng-controller="AccountController">
        <div class="container" ng-init="LoadOrders()">
        
        <div class="row">
            <main class="col-sm-10 offset-md-1">
        
            <article>
                <div class=""  style="margin: 20px;">
                    <button class="btn btn-warning" ng-click="EditAccount({{ $user->id }})">Edit Account</button>
                    <button class="btn btn-warning" ng-click="SendContact({{ $user->id }})">Contact Supplier</button>
                </div>
                <table style="margin: 20px;" class="table">
                    <thead class="thead-light">
                        <th>#&nbsp;</th>
                        <th>Date</th>
                        <th>Value</th>
                        <th>Status</th>
                        <th class="d-none d-sm-block">Options</th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="order in orders">
                            <td><a href="{{ url('/account/orders/') }}/<% order.id %>">#<% order.id %></td>
                            <td><% order.date %></td>
                            <td><% order.total %></td>
                            <td><% order.status_name %></td>
                            <td class="d-none d-sm-block">
                                <button class="btn btn-warning btn-sm" ng-click="RemakeOrder(order)">
                                
                                <span class="d-none d-lg-none d-xl-none">
                                    <i class="fa fa-spinner" ng-hide="order.creating_order"></i>
                                    <i class="fa fa-spinner fa-spin" ng-show="order.creating_order"></i>
                                </span>

                                    <span class="d-none d-lg-block d-xl-block">
                                        <i class="fa fa-spinner" ng-hide="order.creating_order"></i>
                                        <i class="fa fa-spinner fa-spin" ng-show="order.creating_order"></i>&nbsp;
                                        Repeat</span>
                                </button>
                                <button class="btn btn-project-secondary btn-sm" ng-click="DisableOrder(order.id)">                                    
                                    <span class="d-none d-lg-block d-xl-block"><i class="fa fa-times"></i>&nbsp;Cancel</span>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                        
            </article>
            </main> <!-- col.// -->
            
        </div>
        
        </div> <!-- container .//  -->

        <form ng-submit="SaveAccount()">
        <div class="modal fade" id="modalAccount" name="modalAccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Edit Account</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">

                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                     </div>
                    <input name="" class="form-control" ng-model="user.name" placeholder="Full name" type="text">
                </div> <!-- form-group// -->
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                     </div>
                    <input name="" class="form-control" ng-model="user.email" placeholder="Email address" type="email">
                </div> <!-- form-group// -->
                <div class="form-group input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                    </div>
                  
                    <input name=""  ng-model="user.phone" class="form-control" placeholder="Phone number" type="text">
                </div> <!-- form-group// -->
                
                <div class="form-group input-group" ng-init="LoadCountries()">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width: 100px;"> Country: </span>
                        </div>
                        <select type="text" required="1" ng-change="LoadStates()" class="form-control"  ng-options="country.id as country.name  for country in countries" ng-model="user.country_id">
                        </select>
                 </div> <!-- form-group// -->

                 <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width: 100px;"> Province: </span>
                        </div>
                        <select type="text" required="1" class="form-control"  ng-options="state.id as state.name  for state in states" ng-model="user.state_id">
                        </select>
                 </div> <!-- form-group// -->

                    <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" style="width: 100px;"> Address </span>
                        </div>
                      
                        <input name=""  ng-model="user.address" class="form-control" placeholder="Address" type="text">
                    </div> <!-- form-group// -->

                    <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" style="width: 100px;"> City </span>
                            </div>
                          
                            <input name=""  ng-model="user.city" class="form-control" placeholder="City" type="text">
                        </div> <!-- form-group// -->

                        <div class="form-group input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" style="width: 100px;">Zip Code </span>
                                </div>
                              
                                <input name=""  ng-model="user.zip_code" class="form-control" placeholder="City" type="text">
                            </div> <!-- form-group// -->          
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-warning">Save changes</button>
        </div>
      </div>
    </div>
    </div>
</form>


        </section>
        @endsection