@extends('layouts.admin')

@section('content')

<div class="page-content container-fluid">
        <div class="row bg-title">
                <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                    <h4 class="page-title">VIEW ORDER COSTS</h4> </div>
                <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                    <!--<a href="#" ng-click="OpenModalCreateProduct()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Product</a>-->
                    <ol class="breadcrumb">
                    <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
                        <li class="active">Orders</li>
                    </ol>
                </div>
                <!-- /.col-lg-12 -->
            </div>
    <div class="row" style="background-color: #fff; padding: 15px;">
            <div class="col-md-12">
                <div class="card card-body printableArea">
                    <h3 class=""><b>INVOICE</b> <span class="pull-right">#{{ $order->id}}</span></h3>
                    <hr>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="pull-left">
                                <address>
                                    <h3>Client,</h3>
                                    <h4 class="font-bold">{{ $order->user_name}}</h4>
                                    <p class="text-muted ml-4">{{ $order->user_address}}</p>
                                        <p class="mt-4"><b>E-Mail :</b> <i class="fa fa-envelope"></i> {{ $order->user_email}}</p>
                                        <p class="mt-4"><b>Phone :</b> <i class="fa fa-phone"></i> {{ $order->user_phone}}</p>
                                </address>
                            </div>
                            <!--<div class="pull-right text-right">
                                <address>
                                    <h3>To,</h3>                                            
                                    <h4 class="font-bold">Royal Trading,</h4>
                                    <p class="text-muted ml-4">219 Connie Cresent, Unit 11 Concord, ON L4K1L4
                                        <br> https://reroyaltrading.ca</p>
                                    <p class="mt-4"><b>Invoice Date :</b> <i class="fa fa-calendar"></i> 05/02/19</p>
                                    <p><b>Due Date :</b> <i class="fa fa-calendar"></i> 05/02/19</p>
                                </address>
                            </div>-->
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive mt-5" style="clear: both;">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th>Description</th>
                                            <th class="text-right">Quantity</th>
                                            <th class="text-right">Unit Cost</th>
                                            <th class="text-right">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($order_products as $product)
                                            <tr>
                                                <td class="text-center"></td>
                                                <td>{{ $product->product_name }}</td>
                                                <td class="text-right">{{ $product->product_quantity }}</td>
                                                <td class="text-right">C$&nbsp;{{ $product->product_price }}</td>
                                                <td class="text-right">C$&nbsp;{{ $product->price_sub_total }} </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12">
                            
                            <div class="pull-right mt-4 text-right">
                                <p>Sub - Total amount: ${{ $order->total }}</p>
                                <p>Tax/Vat (0.00%) : $0 </p>
                                <hr>
                                <h3><b>Total :</b> CAD {{ $order->total }}</h3>
                            </div>
                            <div class="clearfix"></div>
                            <hr>
                            <div class="pull-right mt-4 text-left">
                                    <!--<div id="paypal-button-container"></div>-->
                                    <button id="print" class="btn btn-project btn-outline" type="button" ng-click="PrintDocument()"> <span><i class="fa fa-print"></i> Print</span> </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="background-color: #fff; margin-top: 30px;">
            <div class="col-md-12">
                    <h3 class=""><b>NOTES</b> <span class="pull-right">#{{ $order->id}}</span></h3>
                    <p class="text-muted">Notes</p>
                    <hr>
                    <div class="table-responsive mt-5" style="clear: both;">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>User</th>
                                        <th class="text-right">Description</th>
                                        <th class="text-right">Created at</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach ($order_notes as $note)
                                        <tr>
                                            <td class="text-center"></td>
                                            <td>{{ $note->user_name }}</td>
                                            <td class="text-right">{{ $note->description }}</td>
                                            <td class="text-right">C$&nbsp;{{ $note->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       
            </div>
        </div>
</div>

@endsection