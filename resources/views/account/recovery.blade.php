@extends('layouts.register')

@section('content')

<div class="row">
    <div class="col-md-12">
        <section class="section-name bg padding-y  text-center">
                <div class="container">
                <h4>Recover you account</h4>
                <p>We need to now how you are.</p>
                </div><!-- container // -->
        </section>
    </div>
</div>
<div class="row" ng-controller="LoginController">
    <div class="col-md-4 offset-md-4">
        <div class="card-body">
            <p>Recover you password by email:</p>
            <form class="pb-3" ng-submit="RecoverAccount()">
                <div class="input-group">
                <input type="text" ng-model="recovery.user_email" class="form-control" placeholder="Email address">
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">
                        <span ng-show="recovering"><i class="fa fa-spin fa-spinner"></i></span>
                        <span ng-hide="recovering"><i class="fa fa-paper-plane"></i></span>
                    </button>
                </div>
                </div>
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