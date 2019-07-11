@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="BrandController">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">BRANDS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" ng-click="OpenModalCreateBrand()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Brand</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Brands</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Brands</h3>
                        <p class="text-muted">Brands on system</p>
                        <img src="{{ asset('public/30.gif') }}" ng-show="loading_brands"/>

                        <div class="row" ng-hide="loading_brands">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllBrands(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBrands(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllBrands($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBrands(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>
                        <div class="table-responsive" ng-hide="loading_brands">
                            <table class="table" ng-init="AdminListAllBrands(0)">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Route&nbsp;<a href="" class="btn btn-sm btn-default" data-toggle="modal" data-target="#modalExplanationRoute">?</a></th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="brand in brands">
                                        <td><% $index+1 %></td>
                                        <td><% brand.name %></td>
                                    <td>
                                        <a class="btn btn-info" href="{{ url('/shopping/category/') }}/<%brand.route%>/products.html">
                                            <%brand.route%> <i class="fa fa-link"></i>
                                        </a>
                                    </td>
                                        <td>
                                            <button class="btn btn-project" ng-click="EditBrand(brand.id)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger" ng-click="DeleteBrand(brand.id)"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBrands(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllBrands($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllBrands(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" tabindex="-1" role="dialog" id="modalExplanationRoute">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">About Routes</h4>
            </div>
            <div class="modal-body">
              <p>Routes are specific links to a brand, for example: <i>wholesalescompany.ca/<strong>adore</strong></i> where Adore is the brand name</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
      </div><!-- /.modal -->

           <form id="formCreateBrand" name="formCreateBrand" ng-submit="SaveBrand()">
            <div class="modal fade" id="modalCreateBrand" name="modalCreateBrand" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create/Edit Brand</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-show="has_error">
                                <% error_message %>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Brand Name</label>
                                <input type="text" required="required" ng-model="brand.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                                <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.name %></small>
                            </div>
                            
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Brand Route</label>
                                    <input type="text" required="required" ng-model="brand.route" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter route">
                                    <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.route %></small>
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
