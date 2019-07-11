@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="SupplierController">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">SUPPLIERS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" ng-click="OpenModalCreateSupplier()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Supplier</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Suppliers</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Suppliers</h3>
                        <p class="text-muted">Suppliers on system</p>
                        <img src="{{ asset('public/30.gif') }}" ng-show="loading_suppliers"/>

                        <div class="row" ng-hide="loading_suppliers">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllSuppliers(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllSuppliers(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllSuppliers($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllSuppliers(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>
                        <div class="table-responsive" ng-hide="loading_suppliers">
                            <table class="table" ng-init="AdminListAllSuppliers(0)">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Email Sales</th>
                                        <th>Finance Mail</th>
                                        <th>Phone</th>
                                        <th>Fax</th>
                                        <th>Options</th>
                                      </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="supplier in suppliers">
                                        <td><% $index+1 %></td>
                                        <td><% supplier.name %></td>
                                        <td><% supplier.description %></td>
                                        <td><% supplier.sales_email %></td>
                                        <td><% supplier.finance_mail %></td>
                                        <td><% supplier.phone %></td>
                                        <td><% supplier.fax %></td>
                                        
                                        <td>
                                            <button class="btn btn-project" ng-click="EditSupplierProducts(supplier.id)"><i class="fa fa-plus"></i></button>
                                            <button class="btn btn-project" ng-click="EditSupplier(supplier.id)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger" ng-click="DeleteSupplier(supplier.id)"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllSuppliers(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllProducts($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllSuppliers(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalSupplierProducts" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                  <h4 class="modal-title" id="myModalLabel">Add Products to Supplier</h4>
                </div>
                <div class="modal-body">

                    <div class="row">
                      <div class="col-md-6 col-xs-12">
                        <div class="form-group">
                                <label for="exampleInputEmail1">Instant Search</label>
                                <input type="text" ng-model="supplier_product_name_search" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                          </div>
                        </div>
                        <div class="col-md-6 col-xs-12">
                        <label for="exampleInputEmail1">Products to add</label>
                            <div class="input-group">
                                    <select class="form-control btn btn-block" ng-model="supplier_product_add_id" ng-options="project.code as project.item  for project in supplier_products_not | filter:supplier_product_name_search:strict">
                                    </select>
                                    <span class="input-group-btn">
                                      <button type="button" ng-click="AddProductToSupplier()" class="btn btn-project">
                                        <i class="fa fa-plus"></i>
                                      </button>
                                    </span>
                                </div>
                              </div>
                          <hr>
                        <div class="tableresponsive" style="margin: 25px;" ng-show="supplier_products.length > 0">
                            <table class="table table-striped">
                              <thead>
                                <th>#</th>
                                <th>Name</th>
                                <th>Options</th>
                              </thead>
                              <tbody>
                                <tr ng-repeat="product in supplier_products">
                                  <td><% $index+1 %></td>
                                  <td><% product.item %></td>
                                  <td><a class="btn btn-danger btn-sm" ng-click="DeleteProductFromSupplier(product.code)"><i class="fa fa-times"></i></a></td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

            <form id="formCreateSupplier" name="formCreateSupplier" ng-submit="SaveSupplier()">
            <div class="modal fade" id="modalCreateSupplier" name="modalCreateSupplier" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create/Edit supplier</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Supplier name</label>
                                <input type="text" ng-model="supplier.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Description</label>
                                <textarea class="form-control" style="min-height: 120px;" ng-model="supplier.description">

                                </textarea>
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Address</label>
                                    <input type="text" ng-model="suplier.address" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Address">
                            </div> 
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Zip Code</label>
                                    <input type="text" ng-model="suplier.zipcode" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Zip Code">
                            </div>                          
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Email for Finance</label>
                                    <input type="text" ng-model="supplier.finance_mail" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email for Finance">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Email for Sales</label>
                                    <input type="text" ng-model="supplier.sales_email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email for Sales">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Phone</label>
                                    <input type="text" ng-model="supplier.phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter phone">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Phone 3CX</label>
                                    <input type="text" ng-model="supplier.phone3cx" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter phone for 3CX">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Fax</label>
                                    <input type="text" ng-model="supplier.fax" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Fax">
                            </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="submit" class="btn btn-project">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>
            </form>
    </div>


@endsection