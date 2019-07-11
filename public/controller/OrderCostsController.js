angular.module("WholeSale").controller("OrderCostsController", function($scope, $http, $window){
    $scope.costs = {};
    $scope.loading_costs = false;
    $scope.items_per_page = 25;
    $scope.current_page = 0;

    $scope.ShowPage = function(page)
    {
        var show = page < ($scope.current_page+3) && page > ($scope.current_page-3);
        
        if($scope.current_page <= 5 && !show)
        {
            show = page <= (8 - page) && page > ($scope.current_page - 3);
        }

        console.log(show);
        return show;
    }

    $scope.EditOrderCosts = function(id)
    {
        var json_url = base_url + "/api/orders/costs/get?cost_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.cost = $data;
            $("#modalSaveCosts").modal("show");
        });
    }

    $scope.DeleteOrderCosts = function(id)
    {
        var json_url = base_url + "/api/orders/costs/delete?cost_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.LoadOrderCosts($scope.current_page);
        });
    }

    $scope.SaveOrderCosts = function()
    {
        var id = $("#order_id").val();
        $scope.cost.order_id = id;

        var json_url = base_url + "/api/orders/costs/save";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.cost), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
               $scope.LoadOrderCosts($scope.current_page);
                $("#modalSaveCosts").modal("hide");
        });
    }

    $scope.LoadOrderCosts = function(page)
    {
        var id = $("#order_id").val();
        var items_per_page = $scope.items_per_page;
        var json_url = base_url + "/api/orders/costs/list?page=" + page + "&order_id=" + id + "&items_per_page=" + items_per_page;

        $http.get(json_url).success(function($data){
            $scope.costs = $data.costs;
            $scope.total_pages = $data.total_pages;
            $scope.loading_orders = false;
            $scope.items_per_page = $data.items_per_page;
        });  
    }
});