@extends('layouts.same')

@section('content')

<section class="section-pagetop bg-secondary">
    <div class="container clearfix">
        <h2 class="title-page">View Order</h2>
    
        <nav class="float-left">
        <ol class="breadcrumb text-white">
            <li class="breadcrumb-item"><a href="{{ route('home_index') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account_index') }}">Account</a></li>
            <li class="breadcrumb-item"><a href="{{ route('account_index') }}">Order</a></li>
        </ol>  
        </nav>
    </div>
    </section>

    <section class="section-content bg padding-y" ng-controller="AccountController">
        <input type="hidden" name="current_url" id="current_url" value="{{ url()->current() }}" />
        <div class="container">
        
        <div class="row">
            <div class="col-sm-10 offset-md-1" style="padding-top: 12px; padding-bottom: 12px;">
                <button class="btn btn-warning" ng-click="ContactSupplier()">Contact Supplier</button>
                <button class="btn btn-secondary" ng-click="LoadContactMessages({{ $order->id }})">Past Contacts</button>                
            </div>
        </div>
        <div class="row">
           

            <main class="col-sm-10 offset-md-1 card">
            
            <article>
                <div class="text-center" style="background-color: #CCC; color: #323232;">
                    <h3 class="title-page" style="padding: 8px; margin: 6px;">Order details</h3>
                </div>
                <table class="table">
                    <tbody>
                        <tr>
                            <td><strong>Order Id:</strong></td>
                            <td>&nbsp;{{ $order->id }}</td>
                        </tr>
                        <tr>
                            <td><strong>Order Date:</strong></td>
                            <td>&nbsp;{{ $order->order_date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Order Total:</strong></td>
                            <td>&nbsp;{{ $order->total }}</td>
                        </tr>
                    </tbody>
                </table>
            </article>
            </main>
        </article>

        </div>
        <div class="row" style=" margin-top: 20px;">
            <main class="col-sm-10 offset-md-1 card">
            <div class="text-center" style="background-color: #CCC; color: #323232; margin-top: 12px;">
                    <h3 class="title-page" style="padding: 8px; margin: 6px;">Products on order</h3>
                </div>

                <table class="table table-striped">
                    <thead>
                        <th>#</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Name</th>
                        <th>Subtotal</th>
                        @if($order->status_id == 1)
                            <th>Option</th>
                        @endif
                    </thead>
                    <tbody>
                        @foreach($products as $product)
                            <tr>
                                <td></td>
                                <td>{{ $product->quantity }}</td>
                                <td>{{ $product->price }}</td>
                                <td>{{ $product->name }}</td>
                                <td>{{ $product->subtotal }}</td>
                                @if($order->status_id == 1)
                                    <td>
                                        <a href="" class="btn btn-danger" ng-click="RemoveProductFromOrder({{ $order->id }} , {{  $product->code }})"><i class="fa fa-times"></i></a>
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
        </div>



     <div class="modal fade" tabindex="-1" role="dialog" id="modalContactAccount" name="modalContactAccount">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Send Contact</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Message</label>
                <textarea type="text" ng-model="contact.message" required="required" class="form-control ng-pristine ng-untouched ng-empty ng-invalid ng-invalid-required" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter message">                </textarea>
            </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-warning" ng-click="SendContact({{ $order->id }})">Send</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
     </div>

     <div class="modal fade" tabindex="-1" role="dialog" id="modalMessages" name="modalMessages">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Last Contacts</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table">
                    <thead>
                        <th>#</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>User</th>
                    </thead>
                    <tbody>
                        <tr ng-repeat="message in messages">
                            <td><% $index+1 %></td>
                            <td><% message.message %></td>
                            <td><% message.created_at %></td>
                            <td><% message.user_name %></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
            </div>
        </div>
     </div>
    </section>


@endsection