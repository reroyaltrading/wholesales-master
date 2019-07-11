@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="UserController">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">USERS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" ng-click="CreateUser()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create User</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Users</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row"  ng-init="LoadCountries()">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Users</h3>
                        <p class="text-muted">Users on system</p>

                        <img src="{{ asset('public/30.gif') }}" ng-show="loading_users"/>

                        <div class="row" ng-hide="loading_users">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllUsers(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllUsers(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllUsers($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllUsers(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>

                        <div class="table-responsive">
                            <table class="table" ng-init="AdminListAllUsers(0)">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th>City</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="user in users">
                                        <td><% $index+1%></td>
                                        <td><% user.name %></td>
                                        <td><% user.email %></td>
                                        <td><% user.phone %></td>
                                        <td><% user.address %></td>
                                        <td><% user.city %></td>
                                        <td>
                                            <button class="btn btn-project" ng-show="user.self_register_user == 0" ng-click="EditUserBrands(user.id)"><i class="fa fa-list-alt"></i></button>                                            
                                            <button class="btn btn-project" ng-show="user.self_register_user == 0" ng-click="EditUserCategories(user.id)"><i class="fa fa-copyright"></i></button>
                                            <button class="btn btn-project-secondary" ng-click="EditUser(user.id)"><i class="fa fa-edit"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                                <nav aria-label="Page navigation example">
                                  <ul class="pagination">
                                    <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllUsers(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                                    <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllUsers($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                                    <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllUsers(current_page+1)"><a class="page-link" href="#">Next</a></li>
                                  </ul>
                                </nav>
                              </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalEditCategories" name="modalEditCategories" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">User Categories</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Category</th>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="category in categories_have">
                                            <td><% category.name %></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" ng-click="DeleteCategoryUser(category.id)"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="input-group">
                                    <select ng-options="category.id as category.name  for category in categories_not" ng-model="id_category" class="form-control btn btn-secondary ng-pristine ng-valid ng-empty ng-touched">
                                    </select>

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning" ng-click="AddCategoryUser()">
                                          <i class="fa fa-spinner fa-spin" ng-show="adding_category"></i>&nbsp;
                                            <span>Add</span>
                                          &nbsp;
                                        </button>
                                      </span>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
            </div>

            <div class="modal fade" id="modalEditBrands" name="modalEditBrands" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">User Brands</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <th>Brand</th>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="brand in brands_have">
                                            <td><% brand.name %></td>
                                            <td>
                                                <button class="btn btn-danger btn-sm" ng-click="DeleteBrandUser(brand.id)"><i class="fa fa-times"></i></button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>

                                <div class="input-group">
                                    <select ng-options="brand.id as brand.name  for brand in brands_not" ng-model="id_brand" class="form-control btn btn-secondary ng-pristine ng-valid ng-empty ng-touched">
                                    </select>

                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning" ng-click="AddBrandUser()">
                                          <i class="fa fa-spinner fa-spin" ng-show="adding_brand"></i>&nbsp;
                                            <span>Add</span>
                                          &nbsp;
                                        </button>
                                      </span>
                                </div>
                            </div>
                        </div>
                      </div>
                    </div>
            </div>

            <form id="formEditUser" name="formEditUser" ng-submit="SaveUser()">
                <div class="modal fade" id="modalCreateUser" name="modalCreateUser" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Create/Edit User</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" ng-model="user.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Email</label>
                                    <input type="text" ng-model="user.email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Phone</label>
                                        <input type="text" ng-model="user.phone" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Address</label>
                                        <input type="text" ng-model="user.address" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Zip Code</label>
                                        <input type="text" ng-model="user.zip_code " class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>
    
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Country</label>
                                        <select class="form-control" ng-change="LoadStates()" ng-options="country.id as country.name  for country in countries" ng-model="user.country_id"></select>
                                </div>
    
                                <div class="form-group">
                                        <label for="exampleInputEmail1">State</label>
                                        <select class="form-control" ng-options="state.id as state.name  for state in states" ng-model="user.state_id"></select>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Password</label>
                                    <input type="text" ng-model="user.new_password " class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                                </div>

                                <div class="checkbox checkbox-warning ">
                                    <input id="see_users_invoices" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="user.ic_admin" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                    <label for="see_users_invoices"> Admin user </label>
                                </div>

                                <hr>
                                <div class="checkbox checkbox-warning ">
                                    <input id="has_purchase_limit" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="user.has_purchase_limit" class="ng-pristine ng-untouched ng-valid ng-not-empty">
                                    <label for="has_purchase_limit"> Has Purchase Limit </label>
                                </div>

                                <div class="form-group" ng-show="user.has_purchase_limit">
                                        <label for="purchase_limit">Purchase Limit</label>
                                        <input type="text" ng-model="user.purchase_limit " class="form-control" id="purchase_limit" aria-describedby="emailHelp" placeholder="Insert the purchase limit">
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