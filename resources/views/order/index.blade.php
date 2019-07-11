@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="OrderController">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12" ng-init="LoadOrderStatuses()">
            <h4 class="page-title">{{ isset($status) ? ' Orders (status: '.$status->name.')' : 'Orders' }}</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <!--<a href="#" ng-click="OpenModalCreateProduct()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Product</a>-->
            <ol class="breadcrumb">
            <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
                <li class="active">{{ isset($status) ? ' Orders (status: '.$status->name.')' : 'Orders' }}</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12" ng-init="{{ isset($status_id) ? 'LoadOrderFromStatuses(0, '.$status_id.')' : 'LoadOrders(current_page)' }}">
                <div class="white-box">
                    <h3 class="box-title">{{ isset($status) ? ' Orders (status: '.$status->name.')' : 'Orders' }}</h3>
                    <p class="text-muted">Orders on system</p>

                    <img src="{{ asset('public/30.gif') }}" ng-show="loading_orders"/>
                    <div class="row" ng-hide="loading_orders">
                            <div class="col-md-1">
                              <select class="form-control" ng-change="{{ isset($status_id) ? 'LoadOrderFromStatuses(current_page, '.$status_id.')' : 'LoadOrders(current_page)' }}" ng-model="items_per_page" style="margin: 20px 0;">
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
                        <table class="table" ng-init="{{ isset($status_id) ? 'LoadOrderFromStatuses(0, '.$status_id.')' : 'LoadOrders(0)' }}">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="order in orders">
                                    <td><% $index+1 %></td>
                                    <td><a href="{{url('/admin/logistics/warehousing/')}}/<%order.id%>.html"><% order.date %></a></td>
                                    <td><% order.user_name %></td>
                                    <td><% order.user_email %></td>
                                    <td><% order.user_phone %></td>
                                    <td><% order.total %></td>
                                    <td>
                                        <div class="dropdown">
                                            <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                              <% order.status_name %>
                                              <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                                              <li ng-repeat="status in statuses">
                                                <a href="#" ng-click="ChangeStatus(order.id, status.id)"><% status.name %></a>
                                              </li>
                                            </ul>
                                          </div>
                                    </td>
                                    <td>
                                        <a href="{{ url('/admin/purchases/orders/costs/') }}/<% order.id %>" class="btn btn-project btn-sm"><i class="fa fa-dollar"></i></a>
                                        <a href="{{ url('/admin/purchases/orders/view/') }}/<% order.id %>" class="btn btn-project btn-sm"><i class="fa fa-eye"></i></a>
                                        <a href="#" class="btn btn-project btn-sm" ng-click="ShowUserComments(order.id)"><i class="fa fa-comments"></i></a>
                                        <a href="#" ng-click="AddNote(order.id)" class="btn btn btn-project-secondary btn-sm"><i class="fa fa-plus"></i><span class="">&nbsp;Notes</span></a>
                                        <a href="#" ng-click="ViewLog(order.id)" class="btn btn btn-primary btn-sm"><i class="fa fa-file"></i><span class="">&nbsp;Logs</span></a>
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

        <div class="modal fade" id="modalShowContactMessages" name="modalShowContactMessages" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Messages on the Order</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                  <div class="table-responsive">
                    <table class="table">
                      <thead>
                        <th>#</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>User</th>
                      </thead>
                      <tbody>
                        <tr ng-repeat="message in contact_messages">
                            <td><% $index+1 %></td>
                            <td><% message.message %></td>
                            <td><% message.created_at %></td>
                            <td><% message.user_name %></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>                  
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
                <h4 class="modal-title">Order notes</h4>
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