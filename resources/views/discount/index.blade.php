@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="DiscountController">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">DISCOUNTS</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
        <a href="{{ route('discount_create') }}" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Discount</a>
            <ol class="breadcrumb">
            <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
                <li class="active">Discounts</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12" ng-init="LoadDiscounts()">
                <div class="white-box">
                    <h3 class="box-title">Discounts</h3>
                    <p class="text-muted">Discounts on system</p>

                    <img src="{{ asset('public/30.gif') }}" ng-show="loading_discounts"/>
                    <div class="row" ng-hide="loading_discounts">
                            <div class="col-md-1">
                              <select class="form-control" ng-change="LoadDiscounts(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                              </select>
                            </div>
                            <div class="col-md-11">
                            <nav aria-label="Page navigation example" class="pull-right">
                              <ul class="pagination">
                                <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="LoadDiscounts(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                                <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="LoadDiscounts($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                                <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="LoadDiscounts(current_page+1)"><a class="page-link" href="#">Next</a></li>
                              </ul>
                            </nav>
                            </div>
                          </div>

                    <div class="table-responsive" id="tblResponsiveDiscounts" style="overflow: inherit!important;">
                        <table class="table" ng-init="LoadDiscounts(0)">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Valid from</th>
                                    <th>Valid To</th>
                                    <th>Percentage</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="discount in discounts">
                                    <td><% discount.id %></td>
                                    <td><% discount.name %></td>
                                    <td><% discount.start_date %></td>
                                    <td><% discount.end_date %></td>
                                    <td><% discount.percentage %></td>
                                    <td>
                                        <a href="{{ url('/admin/marketing/discounts/') }}/<% discount.id %>/edit.html" class="btn btn-project btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="#" ng-click="ViewLog(order.id)" class="btn btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                        <nav aria-label="Page navigation example">
                          <ul class="pagination">
                            <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="LoadDiscounts(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                            <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="LoadDiscounts($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                            <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="LoadDiscounts(current_page+1)"><a class="page-link" href="#">Next</a></li>
                          </ul>
                        </nav>
                      </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="modalLoadingData" name="modalLoadingData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Changing Status</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <img src="{{ asset('public/30.gif') }}"/>
              </div>
            </div>
          </div>
        </div>
        <form id="formViewLog" name="formViewLog">
            <div class="modal fade" id="modalViewLog" name="modalViewLog" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">View Change Log</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive" id="tblResponsiveOrderLogs" style="overflow: inherit!important;">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>User</th>
                                            <th>Initial Status</th>
                                            <th>Current Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                      <tr ng-repeat="log_item in log_items">
                                          <td><% $index+1 %></td>
                                          <td><% log_item.username %></td>
                                          <td><% log_item.previous_status_name %></td>
                                          <td><% log_item.current_status_name %></td>
                                          <td><% log_item.created_date %>
                                      </tr>
                                    </tbody>
                                </table>         
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </form>

        <form ng-submit="SendOrderNote()">
        <div class="modal fade" name="modalAddNote" id="modalAddNote" tabindex="-1" role="dialog">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
              </div>
              <div class="modal-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Description</label>
                  <textarea class="form-control ng-pristine ng-valid ng-empty ng-touched" style="min-height: 120px;" ng-model="order_note.description">
                  </textarea>
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