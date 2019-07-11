@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="NewsletterController">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">NEWSLETTER</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <a href="#" ng-click="OpenModalCreateMail()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Email</a>
            <ol class="breadcrumb">
            <li><a href="{{ route('admin_console') }}">Dashboard</a></li>
                <li class="active">Newsletter</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">Newsletter templates</h3>
                    <p class="text-muted">Templates on system</p>

                    <img src="{{ asset('public/30.gif') }}" ng-show="loading_templates"/>
                    <div class="row" ng-hide="loading_templates">
                            <div class="col-md-1">
                              <select class="form-control" ng-change="LoadMails(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="250">250</option>
                              </select>
                            </div>
                            <div class="col-md-11">
                            <nav aria-label="Page navigation example" class="pull-right">
                              <ul class="pagination">
                                <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="LoadMails(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                                <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="LoadMails($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                                <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="LoadMails(current_page+1)"><a class="page-link" href="#">Next</a></li>
                              </ul>
                            </nav>
                            </div>
                          </div>
                    <div class="table-responsive">
                        <table class="table" ng-init="LoadMails(0)">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Date</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="template in templates">
                                    <td><% template.id %></td>
                                    <td><% template.created_date %></td>
                                    <td><% template.name %></td>
                                    <td><% template.description %></td>
                                    <td>

                                        <a href="#" ng-click="SendMail(template)" class="btn btn-project btn-sm"><span ng-show="template.loading"><i class="fa fa-spin fa-spinner"></i>&nbsp;</span><i class="fa fa-paper-plane"></i></a>
                                        <a href="#" ng-click="EditMail(template.id)" class="btn btn-project-secondary btn-sm"><i class="fa fa-edit"></i></a>
                                        <a href="#" ng-click="DeleteMail(template.id)" class="btn btn-danger btn-sm"><i class="fa fa-times"></i></a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div>
                            <nav aria-label="Page navigation example">
                              <ul class="pagination">
                                <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="LoadMails(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                                <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="LoadMails($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                                <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="LoadMails(current_page+1)"><a class="page-link" href="#">Next</a></li>
                              </ul>
                            </nav>
                          </div>
                </div>
            </div>
        </div>

        <form id="formCreateEmail" name="formCreateEmail" ng-submit="SaveMail()">
                <div class="modal fade" id="modalCreateEmail" name="modalCreateEmail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="document">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="exampleModalLabel">Create/Edit Mail</h5>
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                              </button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group">
                                    <label for="exampleInputEmail1">Name</label>
                                    <input type="text" ng-model="mail.name" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Name">
                                </div>
                               
                                <div class="form-group">
                                        <label for="exampleInputEmail1">Description</label>
                                        <input type="text" ng-model="mail.description" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Description">
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputEmail1">Content</label>
                                    <div class="html-editor-cm" id="summernote_root">
    
                                    </div>
                                </div>

                                <div class="checkbox checkbox-warning ">
                                  <input id="pin_menu_bar" type="checkbox" ng-true-value="1" ng-false-value="0" ng-model="mail.send_to_buyers" class="ng-pristine ng-untouched ng-valid ng-empty">
                                  <label for="pin_menu_bar"> Send to buyers of a brand</label>
                                </div>

                                <div class="form-group" ng-show="mail.send_to_buyers" ng-init="LoadBrands()">
                                    <label for="exampleInputEmail1">Brands</label>
                                    <select class="form-control ng-pristine ng-valid ng-empty ng-touched" ng-options="brand.id as brand.name  for brand in brands" ng-model="mail.brand_id">
                                    </select>
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

@section('pagescript')
    <script src="{{ asset('public/summernote/summernote-updated.min.js') }}"></script>
    <script src="{{ asset('public/summernote/summernote-active.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote();
        });
    </script>
@endsection