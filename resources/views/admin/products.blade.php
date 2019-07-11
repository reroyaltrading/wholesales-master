@extends('layouts.admin')

@section('content')

<div class="container-fluid" ng-controller="ProductController">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">PRODUCTS</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <a href="#" ng-click="OpenModalCreateProduct()" class="btn btn-project pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light">Create Product</a>
                <ol class="breadcrumb">
                    <li><a href="#">Dashboard</a></li>
                    <li class="active">Products</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div class="white-box">
                        <h3 class="box-title">Products</h3>
                        <p class="text-muted">Products on system</p>
                        <img src="{{ asset('public/30.gif') }}" ng-show="loading_products"/>

                        <div class="row" ng-hide="loading_products">
                          <div class="col-md-1">
                            <select class="form-control" ng-change="AdminListAllProducts(current_page)" ng-model="items_per_page" style="margin: 20px 0;">
                              <option value="25">25</option>
                              <option value="50">50</option>
                              <option value="100">100</option>
                              <option value="250">250</option>
                            </select>
                          </div>
                          <div class="col-md-11">
                          <nav aria-label="Page navigation example" class="pull-right">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllProducts(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllProducts($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllProducts(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                          </div>
                        </div>
                        <div class="table-responsive" ng-hide="loading_products">
                            <table class="table" ng-init="AdminListAllProducts(1)">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Type</th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th>Gross Price</th>
                                        <th>Route</th>
                                        <th>Category</th>
                                        <th>Options</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="product in products">
                                        <td><% $index+1 %></td>
                                        <td><% product.product_type_name_str %></td>
                                        <td><a target="_blank" href="{{ url('shopping/product') }}/<% product.code %>.html"><% product.item %></a></td>
                                        <td><% product.price %></td>
                                        <td><% product.gross_price %></td>
                                        <td><% product.route %></td>
                                        <td><% product.category_name_str %></td>
                                        <td>
                                            <button class="btn btn-project" ng-click="EditProduct(product.code)"><i class="fa fa-edit"></i></button>
                                            <button class="btn btn-project-secondary" ng-click="EditProductImages(product.code)"><i class="fa fa-image"></i></button>
                                            <button class="btn btn-danger" ng-click="DeleteProduct(product.code)"><i class="fa fa-times"></i></button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                          <nav aria-label="Page navigation example">
                            <ul class="pagination">
                              <li class="page-item <% current_page == 1 ? 'enabled' : 'disabled' %>" ng-click="AdminListAllProducts(current_page-1)"><a class="page-link" href="#">Previous</a></li>
                              <li ng-repeat="x in [].constructor(total_pages) track by $index" ng-show="ShowPage($index)" class="page-item <% $index==current_page ? 'active' : '' %>" ng-click="AdminListAllProducts($index)"><a class="page-link" href="#"><% $index+1 %></a></li>
                              <li class="page-item <% current_page < total_pages ? 'enabled' : 'disabled' %>" ng-click="AdminListAllProducts(current_page+1)"><a class="page-link" href="#">Next</a></li>
                            </ul>
                          </nav>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal fade" id="modalPictures" name="modalPictures" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <div class="row">
                              <div class="col-md-2 text-center" ng-repeat="picture in pictures">
                                  <div class="image-display fill">
                                    <img class="img-responsive" src="{{ asset('/storage') }}/<% picture.location%>" />
                                  </div>
                                  <button style="margin: 10px;" ng-click="DeletePicture(picture.id)" class="btn btn-project-secondary btn-sm btn-block"><i class="fa fa-times"></i></button>
                              </div>
                          </div>
                        </div>
                        <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>
                      </div>
                    </div>
                  </div>

            <form id="formCreateProduct" name="formCreateProduct" ng-submit="SaveProduct()">
            <div class="modal fade" id="modalCreateProduct" name="modalCreateProduct" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Create/Edit Product</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Product Name</label>
                                <input type="text" ng-model="product.item" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">Cold Description</label>
                                <textarea class="form-control" style="min-height: 120px;" ng-model="product.description">

                                </textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="exampleInputEmail1">Detail overview</label>
                                <div class="html-editor-cm" id="summernote_root">

                                </div>
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Price</label>
                                    <input type="text" ng-model="product.price" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Min Quantity (Stock)</label>
                                    <input type="text" ng-model="product.minimum_stock" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Barcode</label>
                                    <input type="text" ng-model="product.barcode" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Qr Code</label>
                                    <input type="text" ng-model="product.qrcode" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Quantity</label>
                                    <input type="text" ng-model="product.items_on_box" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>
                            <div class="form-group">
                                    <label for="exampleInputEmail1">Gross Price</label>
                                    <input type="text" ng-model="product.gross_price" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
                            </div>

                            <div class="form-group">
                                    <label for="exampleInputEmail1">Type</label>
                                    <select class="form-control" ng-options="type.id as type.name  for type in types" ng-model="product.product_type_id"></select>
                            </div>

                            <div class="form-group">
                                    <label for="exampleInputEmail1">Brand</label>
                                    <select class="form-control" ng-options="category.id as category.name  for category in categories" ng-model="product.category_id"></select>
                            </div>

                            <div class="form-group">
                                <input type="hidden" value="{{ route('ajax_upload_file') }}" name="dropzone_url" id="dropzone_url" />
                                <div class="multi-uploader-cs">
                                        <div id="dropzone_test" method="post" style="border: 2px dashed #2f323e; margin-top: 20px;" action="{{ route('ajax_upload_file') }}" class="dropzone dz-clickable">
                                            
        
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