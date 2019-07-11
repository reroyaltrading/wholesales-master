@extends('layouts.admin')
@section('content')


<div class="container-fluid" ng-controller="ContactController">
    <div class="row bg-title">
        <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
            <h4 class="page-title">SUPPLIER CONTACT</h4> </div>
        <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
            <ol class="breadcrumb">
                <li><a href="#">Dashboard</a></li>
                <li class="active">Supplier Contact</li>
            </ol>
        </div>
        <!-- /.col-lg-12 -->
    </div>
    <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title">Contacts</h3>
                    <a href="{{ url('/export/contacts') }}" class="btn btn-success pull-right" role="button">Export to Excel</a>
                    <p class="text-muted">Supplier Contact</p>
                    <div class="table-responsive">
                        <table class="table" ng-init="AdminListAllContacts()">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Message</th>
                                    <th>Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="contact in contacts">
                                    <td><% $index+1 %></td>
                                    <td><% contact.name %></td>
                                    <td><% contact.email %></td>
                                    <td><% contact.message %></td>
                                    <td>
                                        <button class="btn btn-project" ng-click="AnswerContact(contact.id)"><i class="fa fa-paper-plane"></i></button>
                                        <button class="btn btn-danger" ng-click="DeleteContact(contact.id)"><i class="fa fa-times"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <form ng-submit="ResponseContact()">
            <div class="modal fade" id="modalResponse" name="modalResponse" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Send Response</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Message</label>
                            <textarea type="text" ng-model="contact_edit.message" required="required" class="form-control ng-not-empty ng-dirty ng-valid-parse ng-valid ng-valid-required ng-touched" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter message">
                            </textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning"><span ng-show="responding_contact"><i class="fa fa-spin fa-spinner"></i>&nbsp;</span>Save changes</button>
                    </div>
                </div>
                </div>
            </div>
        </form>
</div>
@endsection