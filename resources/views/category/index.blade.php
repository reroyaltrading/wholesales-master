@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="CategoryController">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">CATEGORIES</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" ng-click="OpenModalCreateCategory()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Category</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Categories</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Categories</h3>
                        <p class="text-muted">Categories on system</p>
                        <img src="{{ asset('public/30.gif') }}" ng-show="loading_categories"/>

                        <div class="row" ng-hide="loading_categories">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllCategories(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllCategories(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllCategories($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllCategories(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>
                        <div class="table-responsive" ng-hide="loading_categories">
                            <table class="table" ng-init="AdminListAllCategories(0)">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Description</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="category in categories">
                                        <td><% $index+1 %></td>
                                        <td><% category.name %></td>
                                        <td><% category.description %></td>
                                        <td>
                                            <button class="btn btn-project" ng-click="EditCategory(category.id)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-danger" ng-click="DeleteCategory(category.id)"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllCategories(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllCategories($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllCategories(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                        </div>
                    </div>
                </div>
            </div>

           <form id="formCreateCategory" name="formCreateCategory" ng-submit="SaveCategory()">
            <div class="modal fade" id="modalCreateCategory" name="modalCreateCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create/Edit Category</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="alert alert-danger" ng-show="has_error">
                                <% error_message %>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Category Name</label>
                                <input type="text" required="required" ng-model="category.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter name">
                                <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.name %></small>
                            </div>
                            
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Category Description</label>
                                    <input type="text" ng-model="category.description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter description">
                                    <small class="form-text text-white-50 text-danger" ng-show="has_error"><% errors.description %></small>
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
