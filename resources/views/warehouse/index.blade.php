@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="WarehouseController">
<input type='hidden' value='{{$id}}' id="id"/>
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">WAREHOUSE STATUS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">WAREHOUSE Status</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">WAREHOUSE Status</h3>
                        <p class="text-muted">WAREHOUSE status on system</p>
                        <img src="{{ asset('public/30.gif') }}" ng-show="loading"/>

                        <div class="row" ng-hide="loading">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllBanners(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBanners(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllBanners($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBanners(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>
                        <div class="table-responsive" ng-hide="loading_banners">
                            <table class="table" ng-init="LoadItems()">
                                <thead>
                                    <tr>
                                        <th>Status</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Order ID</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="item in items">
                                        <td>
                                        <div class="checkbox checkbox-info ">
                                            <input id="see_users_invoices" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="user.ic_admin" class="ng-valid ng-not-empty ng-dirty ng-valid-parse ng-touched">
                                            <label for="see_users_invoices"> OK </label>
                                         </div>
                                        </td>
                                        <td><% item.item %></td>
                                        <td><% item.quantity %></td>
                                        <td><% item.purchase_order_id %></td>
                                        <td>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBanners(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllBanners($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBanners(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                        </div>
                    </div>
                </div>
            </div>

           <form id="formCreateBanner" name="formCreateBanner" ng-submit="SaveBanner()">
            <div class="modal fade" id="modalCreateBanner" name="modalCreateBanner" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create/Edit Banner</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-show="has_error">
                                <% error_message %>
                            </div>
                            <div class="form-group">
                                <label for="banner_name">Banner Name</label>
                                <input type="text" required="required" ng-model="banner.name" class="form-control" id="banner_name" aria-describedby="emailHelp" placeholder="Enter name">
                                <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.name %></small>
                            </div>
                            
                            <div class="form-group">
                                    <label for="banner_start_date">Banner Valid From</label>
                                    <input type="text" required="required" ng-model="banner.start_date" class="form-control datepicker" id="banner_start_date" aria-describedby="emailHelp" placeholder="Banner start date">
                                    <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.start_date %></small>
                            </div>
                            <div class="form-group">
                                <label for="banner_end_date">Banner Valid To</label>
                                <input type="text" required="required"  ng-model="banner.end_date" class="form-control datepicker" id="banner_end_date" aria-describedby="emailHelp" placeholder="Banner end date">
                                <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.end_date %></small>
                            </div>

                            <div class="form-group">
                              <label for="banner_end_date">Banner Url</label>
                              <input type="text" required="required"  ng-model="banner.url_link" class="form-control" id="banner_end_date" aria-describedby="emailHelp" placeholder="Banner Url">
                              <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.url_link %></small>
                          </div>


                            <div class="form-group">
                              <input type="hidden" value="{{ route('ajax_upload_banner') }}" name="dropzone_url" id="dropzone_url" />
                              <div class="multi-uploader-cs">
                                      <div id="dropzone_test" method="post" style="border: 2px dashed #2f323e; margin-top: 20px;" action="{{ route('ajax_upload_banner') }}" class="dropzone dz-clickable">
                                          
      
                                              <div class="dz-message needsclick download-custom">
                                                      <i class="notika-icon notika-cloud"></i>
                                                      <h2>Drop images here or click to upload.</h2>
                                                      <p><span class="note needsclick">Accepted formats are <strong>png, jpg and gif</strong> on system</span>
                                                      </p>
                                                  </div>
                                      </div>
                                      </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-project"><span ng-show="saving"><i class="fa fa-spin fa-spinner"></i>&nbsp;</span> Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </form>
    </div>

@endsection