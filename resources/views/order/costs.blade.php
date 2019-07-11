@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="OrderCostsController">
    <input class="" type="hidden" name="order_id" id="order_id" value="{{ $order_id }}" />
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">ORDER COSTS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <!--<a href="#" ng-click="OpenModalCreateProduct()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Product</a>-->
            <ol class="breadcrumb">
            <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
            <li><a href="{{ route('orders_index') }}">Orders</a></li>
            <li class="active">Costs</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12" ng-init="LoadOrderCosts(current_page)">
                <div class="white-box">
                    <h3 class="box-title">Order costs</h3>
                    <p class="text-muted">Orders costs on system</p>

                    <img src="{{ asset('public/30.gif') }}" ng-show="loading_order_costs"/>
                    <div class="row" ng-hide="loading_order_costs">
                            <div class="col-md-1">
                              <select class="form-control" ng-change="LoadOrderCosts(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                              </select>
                            </div>
                            <div class="col-md-11">
                            <nav aria-label="Page navigation example" class="pull-right">
                              <ul class="pagination">
                                <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses(current_page-1, '.$status_id.')' : 'LoadOrders(current_page-1)' }}"><a class="page-link" href="#">Previous</a></li>
                                <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses($index, '.$status_id.')' : 'LoadOrders($index)' }}"><a class="page-link" href="#"><% $index+1 %></a></li>
                                <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses(current_page-1, '.$status_id.')' : 'LoadOrders(current_page+1)' }}"><a class="page-link" href="#">Next</a></li>
                              </ul>
                            </nav>
                            </div>
                          </div>

                    <div class="table-responsive" id="tblResponsiveOrders" style="overflow: inherit!important;">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Value</th>
                                    <th>Created by</th>
                                    <th>Created at</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="cost in costs">
                                    <td><% $index+1 %></td>
                                    <td><% cost.name %></td>
                                    <td><% cost.value %></td>
                                    <td><% cost.created_by %></td>
                                    <td><% cost.created_at %></td>
                                    <td>
                                        <a class="btn btn-warning btn-sm" ng-click="EditOrderCosts(cost.id)"><i class="fa fa-edit"></i></a>
                                        <a class="btn btn-danger btn-sm" ng-click="DeleteOrderCosts(cost.id)"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <nav aria-label="Page navigation example">
                          <ul class="pagination">
                          <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses(current_page-1, '.$status_id.')' : 'LoadOrders(current_page-1)' }}"><a class="page-link" href="#">Previous</a></li>
                                <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses($index, '.$status_id.')' : 'LoadOrders($index)' }}"><a class="page-link" href="#"><% $index+1 %></a></li>
                                <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="{{ isset($status_id) ? 'LoadOrderFromStatuses(current_page-1, '.$status_id.')' : 'LoadOrders(current_page+1)' }}"><a class="page-link" href="#">Next</a></li>
                          </ul>
                        </nav>
                      </div>
                </div>
            </div>
        </div>

        
        <form ng-submit="SaveOrderCosts()">
        
        <div class="modal fade" name="modalSaveCosts" id="modalSaveCosts" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Add / Edit Cost</h4>
              </div>
              <div class="modal-body">
              <div class="form-group">
                  <label for="exampleInputEmail1">Name</label>
                  <input class="form-control ng-pristine ng-valid ng-empty ng-touched" ng-model="cost.name" />
              </div>
              <div class="form-group">
                  <label for="exampleInputEmail1">Value</label>
                  <input class="form-control ng-pristine ng-valid ng-empty ng-touched" ng-model="cost.value" />
              </div>
                
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-project">Save changes</button>
              </div>
            </div><!-- /.modal-content -->
          </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        </form>
        
</div>

@endsection