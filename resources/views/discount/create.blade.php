@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="DiscountController">
        <input type="hidden" name="id" id="id" value="{{ $id }}"/>
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">EDIT DISCOUNT</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
                <li><a href="{{ route('discount_index') }}">Discounts</a></li>
                <li class="active">Edit</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row" {{ $operation_create ? '' : 'ng-init=GetDataFromDiscount('.$id.')' }}>
            <div class="col-sm-12">
                    <div class="white-box">
                            <h3 class="box-title">Discounts</h3>
                            <p class="text-muted">Discounts on system</p>

                            <div>
                                    <form ng-submit="SaveDiscount({{ $id }})">
                                            <div class="row">
                                                    <div class="col-md-2">
                                                                <div class="checkbox checkbox-warning ">
                                                                                <input id="discount_by_percentage" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.by_percentage" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_by_percentage"> By percentage </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning ">
                                                                                <input id="discount_by_period" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.by_period" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_by_period"> By period </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning ">
                                                                                <input id="discount_by_brand" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.by_brand" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_by_brand"> By brand </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning ">
                                                                                <input id="discount_by_client" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.by_client" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discoundiscount_by_clientt_by_brand"> By Customer </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning ">
                                                                                <input id="discount_by_category" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.by_category" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_by_category"> By category </label>
                                                                </div>
                                                                <!--
                                                                <div class="checkbox checkbox-warning " ng-show="discount.by_client">
                                                                                <input id="discount_all_clients" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.all_clients" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_all_clients"> All clients </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning " ng-show="discount.by_brand">
                                                                                <input id="discount_all_brands" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.all_brands" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_all_brands"> All Brands </label>
                                                                </div>
                                                                <div class="checkbox checkbox-warning " ng-show="discount.by_category">
                                                                                <input id="discount_all_categories" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="discount.all_categories" class="ng-pristine ng-untouched ng-valid ng-empty">
                                                                                <label for="discount_all_categories"> All categories </label>
                                                                </div>
                                                                -->
                                                    </div>

                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                                <label for="discount_name">Name</label>
                                                                <input type="text" required="1" class="form-control" id="discount_name" ng-model="discount.name" placeholder="Name">
                                                        </div>
                                                        <div class="form-group">
                                                                <label for="discount_percentage">
                                                                        <span  ng-show="discount.by_percentage">Percentage</span>
                                                                        <span  ng-hide="discount.by_percentage">Value</span>
                                                                </label>
                                                                <input type="number" class="form-control" required="1" ng-model="discount.percentage" id="discount_percentage" placeholder="Percentage">
                                                        </div>
                                                        
                                                        <div class="form-group" ng-show="discount.by_period">
                                                                <label for="discount_valid_from">Valid from:</label>
                                                                <input type="text" class="form-control" ng-model="discount.start_date" id="discount_valid_from" placeholder="Valid from: 06/25/2019">
                                                        </div>
                                                        <div class="form-group" ng-show="discount.by_period">
                                                                <label for="discount_valid_to">Valid to:</label>
                                                                <input type="text" class="form-control" ng-model="discount.end_date" id="discount_valid_to" placeholder="Valid to: 06/25/2019">
                                                        </div>
                                                        <div class="form-group">
                                                                <button class="btn btn-warning" ><span ng-show="saving"><i class="fa fa-spin fa-spinner"></i>&nbsp;</span>Save</button>
                                                        </div>
                                                    </div>
                                            </div>
                                          </form>
                            </div>
                    </div>
            </div>
    </div>
    <div class="row">
                        
                <div class="col-md-12">
                                        <div class="white-box" ng-show="discount.by_brand">
                                                
                                                <h3 class="box-title">Discounts by brands
                                                        <div class="pull-right">
                                                                <button class="btn btn-warning" ng-click="AddBrand({{ $id }})">Add</button>
                                                        </div>
                                                 </h3>

                                                <div class="table-responsive">
                                                        <table class="table">
                                                                <thead>
                                                                        <th>Brand Id</th>
                                                                        <th>Brand Name</th>
                                                                        <th>Options</th>
                                                                </thead>
                                                                <tbody>
                                                                        <tr ng-repeat="brand in brands">
                                                                                <td><% brand.id %></td>
                                                                                <td><% brand.name %></td>
                                                                                <td><a href="#" ng-click="RemoveBrand({{ $id }}, brand.id)" class="btn btn-danger btn-sm"><i class="fa fa-times"></a></td>
                                                                        </tr>
                                                                </tbody>
                                                        </table>
                                                </div>
                                        </div>

                                        <div class="white-box"  ng-show="discount.by_category">
                                                <h3 class="box-title">Discounts by categories
                                                                <div class="pull-right">
                                                                                <button class="btn btn-warning" ng-click="AddCategory({{ $id }})">Add</button>
                                                                        </div>
                                                </h3>
                                                <div class="table-responsive">
                                                                <table class="table">
                                                                        <thead>
                                                                                <th>Category Id</th>
                                                                                <th>Category Name</th>
                                                                                <th>Options</th>
                                                                        </thead>
                                                                        <tbody>
                                                                                        <tr ng-repeat="category in categories">
                                                                                                <td><% category.id %></td>
                                                                                                <td><% category.name %></td>
                                                                                                <td><a href="#" ng-click="RemoveCategory({{ $id }}, category.id)" class="btn btn-danger btn-sm"><i class="fa fa-times"></a></td>
                                                                                        </tr>
                                                                                </tbody>
                                                                </table>
                                                        </div>
                                        </div>
                            
                                        <div class="white-box"  ng-show="discount.by_client">
                                                <h3 class="box-title">Discounts by clients
                                                                <div class="pull-right">
                                                                                <button class="btn btn-warning" ng-click="AddClient({{ $id }})">Add</button>
                                                                        </div>
                                                </h3>
                                                <div class="table-responsive">
                                                                <table class="table">
                                                                        <thead>
                                                                                <th>Client Id</th>
                                                                                <th>CLient Name</th>
                                                                                <th>Options</th>
                                                                        </thead>
                                                                        <tbody>
                                                                                        <tr ng-repeat="client in clients">
                                                                                                <td><% client.id %></td>
                                                                                                <td><% client.name %></td>
                                                                                                <td><a href="#"  ng-click="RemoveClient({{ $id }}, client.id)" class="btn btn-danger btn-sm"><i class="fa fa-times"></a></td>
                                                                                        </tr>
                                                                                </tbody>
                                                                </table>
                                                        </div>
                                        </div>
                            </div>
                            </div>


        <!-- MODALS -->
        <div class="modal fade" tabindex="-1" role="dialog" name="modalAddBrand" id="modalAddBrand">
                        <div class="modal-dialog" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title">Add Brand</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                              <select class="form-control" ng-model="selected_brand_id" ng-options="brand.id as brand.name  for brand in brands_not"></select>

                            </div>
                            <div class="modal-footer">
                              <button type="button" class="btn btn-warning" ng-click="FinishAddProduct({{ $id }})">Add</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </div>
                        </div>
                </div>
                <div class="modal fade" tabindex="-1" role="dialog" name="modalAddClient" id="modalAddClient">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title">Add Client</h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body">
                                      <select class="form-control" ng-model="selected_client_id" ng-options="client.id as client.name  for client in clients_not"></select>

                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-warning" ng-click="FinishAddClient({{ $id }})">Add</button>
                                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                  </div>
                                </div>
                        </div>
                        <div class="modal fade" tabindex="-1" role="dialog" name="modalAddBrand" id="modalAddCategory">
                                        <div class="modal-dialog" role="document">
                                          <div class="modal-content">
                                            <div class="modal-header">
                                              <h5 class="modal-title">Add Category</h5>
                                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                              </button>
                                            </div>
                                            <div class="modal-body">
                                              <select class="form-control" ng-model="selected_category_id" ng-options="category.id as category.name  for category in categories_not"></select>

                                            </div>
                                            <div class="modal-footer">
                                              <button type="button" class="btn btn-warning" ng-click="FinishAddCategory({{ $id }})">Add</button>
                                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            </div>
                                          </div>
                                        </div>
                                </div>
          </div>

@endsection