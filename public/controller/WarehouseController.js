angular.module("WholeSale").controller("WarehouseController", function($scope, $http, $window){
    
    $scope.LoadItems=function()
    {
        var id=$("#id").val();
        var json_url = base_url + "/api/orders/items/" + id;
        $http.get(json_url).success(function($data){
            $scope.items = $data;
        });
    }
    });