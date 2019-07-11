
    @extends('layouts.register')

    @section('content')
    <section class="bg-light" style="padding-top: 45px; padding-bottom: 45px;" ng-controller="RegisterController">
            <div class="container">
<div class="row">
<aside class="offset-md-3 col-md-6">
      
        <div id="code_register_2">
        <div class="card">
        <article class="card-body">
            <h4 class="card-title mt-3 text-center">Create Account</h4>
            <p class="text-center">Get started with your free account</p>
            
            <form ng-submit="RegisterUser()" id="formRegister" name="formRegister">
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                 </div>
                <input name="name" ng-model="user.name" required="1"  class="form-control" placeholder="Full name" type="text">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-envelope"></i> </span>
                 </div>
                <input name="email" ng-model="user.email" required="1"  class="form-control" placeholder="Email address" type="email">
            </div> <!-- form-group// -->
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-phone"></i> </span>
                </div>
                <input name="phone" id="phone" ng-model="user.phone" required="1"  class="form-control" placeholder="Phone number" type="text">
            </div> <!-- form-group// -->

                <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Country:</span>
                        </div>
                        <select ng-change="LoadStates()" required="1"  name="country" id="country" ng-model="user.country_id" class="form-control" placeholder="State/Province">
                            @foreach ($countries as $country)
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                 </div> <!-- form-group// -->

                 <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> Province: </span>
                        </div>
                        <select type="text" required="1" vclass="form-control"  ng-options="state.id as state.name  for state in states" ng-model="user.state_id">
                        </select>
                 </div> <!-- form-group// -->

                 <div class="form-group input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                        </div>
                        <input name="address" id="address" required="1"  ng-model="user.address" class="form-control" placeholder="Address" type="text">
                    </div> <!-- form-group// -->

                    <div class="form-group input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-building"></i> </span>
                            </div>
                            <input name="address" required="1"  id="address" ng-model="user.city" class="form-control" placeholder="City" type="text">
                        </div> <!-- form-group// -->
          
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" ng-change="ValidatePasswords()" ng-model="user.password" placeholder="Create password" type="password"> 
            </div> <!-- form-group// -->
            <p class="text-danger" ng-show="wrongpassword"><% password_error %><p>
            <div class="form-group input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                </div>
                <input class="form-control" ng-change="ValidatePasswords()" ng-model="user.repeat" placeholder="Repeat password" type="password">
            </div> <!-- form-group// -->                                      
            <div class="form-group">
                <button type="submit" ng-disabled="formRegister.$invalid || wrongpassword" class="btn btn-primary btn-block"><span ng-show="saving"><i class="fa fa-spin fa-spinner"></i></span> Create Account  </button>
            </div> <!-- form-group// -->      
        <p class="text-center">Have an account? <a href="{{ route('home_index') }}">Log In</a> </p>                                                                 
        </form>
        </article>
        </div> <!-- card.// -->
        </div> <!-- code-wrap.// -->
            </aside>
        </div>
            </div>
    </section>
            @endsection