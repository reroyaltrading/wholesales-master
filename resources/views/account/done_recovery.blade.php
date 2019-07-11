@extends('layouts.register')

@section('content')


<div class="row">
        <div class="col-md-12">
            <section class="section-name bg padding-y  text-center">
                    <div class="container">
                    <h4>Recover you account</h4>
                    <p>Type your new password above.</p>
                    </div><!-- container // -->
            </section>
        </div>
    </div>
    <div class="row" ng-controller="LoginController">
        <div class="col-md-4 offset-md-4">
            <div class="card-body">
                <p>Recover you password by email:</p>
                <form name="formRecoverPassword" id="formRecoverPassword" ng-submit="CompletePasswordRecovery()">
                        <input type="hidden" value="{{ $hash }}" name="recovery_hash" id="recovery_hash" />
                        
                        <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-user"></i> </span>
                             </div>
                            <input name="email" disabled="disabled" class="form-control" value="{{ isset($user) ? $user->email : '' }}" placeholder="Email or login" type="text">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->
                        
                        <div class="form-group">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                             </div>
                            <input class="form-control" ng-model="user_recover.password" placeholder="Password" type="password">
                        </div> <!-- input-group.// -->
                        </div> <!-- form-group// -->

                        <div class="form-group">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                     </div>
                                    <input class="form-control" ng-model="user_recover.retype_password" placeholder="Retype password" type="password">
                                </div> <!-- input-group.// -->
                                    <p ng-show="retype_password!=password" class="text-danger">Please retype an equal password</p>
                                </div> <!-- form-group// -->
                        
                        <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-block" ng-disabled="formRecoverPassword.$invalid || user_recover.retype_password!=user_recover.password"> Change password  </button>
                        </div> <!-- form-group// -->
                        </form>

                <!--<p>Recover you password by phone:</p>
                <form class="pb-3">
                        <div class="input-group">
                        <input type="text" class="form-control" placeholder="Phone number">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button"><i class="fa fa-paper-plane"></i></button>
                        </div>
                        </div>
                    </form>-->
            </div>
        </div>
    </div>

@endsection