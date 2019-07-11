angular.module("WholeSale").controller("ContactController", function($scope, $http, $window){
    $scope.contacts = {};
    $scope.response_message = {};

    $scope.contact_edit = {};
    $scope.responding_contact = false;

    $scope.AnswerContact = function($id)
    {
        $scope.contact_edit.id = $id;
        $("#modalResponse").modal("show");
    }

    $scope.AdminListAllContacts = function()
    {
        var json_url = base_url + "/api/contact/listall";
        $http.get(json_url).success(function($data){
            $scope.contacts = $data;
        });
    };

    $scope.DeleteContact = function($id)
    {
        var json_url = base_url + "/api/contact/delete?contact_id=" + $id;
        $http.get(json_url).success(function($data){
            $scope.AdminListAllContacts();
        });
    }

    $scope.ResponseContact = function()
    {
        var json_url = base_url + "/api/contacts/response";
        $scope.responding_contact = true;
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.contact_edit), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
        }).success(function($data) {
            $scope.responding_contact = false;
            $("#modalResponse").modal("hide");
        });
    }
});
