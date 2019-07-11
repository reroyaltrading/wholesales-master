angular.module("WholeSale").controller("OrderController", function($scope, $http, $window){
    $scope.orders = {};
    $scope.loading_orders = false;

    $scope.order_note = {};
    $scope.selected_order_id = 0;

    $scope.items_per_page = 25;
    $scope.current_page = 0;
    $scope.loading_orders = false;

    $scope.LoadOrders = function(page = 0)
    {
        $scope.current_page = page;
        $scope.loading_orders = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/ajax/orders/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.orders = $data.orders;
            $scope.total_pages = $data.total_pages;
            $scope.loading_orders = false;
            $scope.items_per_page = $data.items_per_page;
        });  
    };

    $scope.LoadOrderFromStatuses = function(page, statud_id)
    {
        $scope.current_page = page;
        $scope.loading_orders = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/ajax/orders/status/listall?page=" + page + "&items_per_page=" + items_per_page + "&status_id=" + statud_id;
        $http.get(json_url).success(function($data){
            $scope.orders = $data.orders;
            $scope.total_pages = $data.total_pages;
            $scope.loading_orders = false;
            $scope.items_per_page = $data.items_per_page;
        });  
    }

    $scope.ViewLog = function(id)
    {
        var json_url = base_url + "/ajax/orders/getlog?order_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.log_items = $data;
            $("#modalViewLog").modal("show");
        });  
    }

    $scope.ShowUserComments = function(order_id)
    {
        var json_url = base_url + "/api/order/contact/getall?order_id="+order_id;
        $http.get(json_url).success(function($data){
            $scope.contact_messages = $data;
            $("#modalShowContactMessages").modal("show");
        });

    }
    
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

    $scope.AddNote = function($id)
    {
        $scope.selected_order_id = $id;
        $("#modalAddNote").modal("show");
    }

    $scope.SendOrderNote = function()
    {
        $scope.order_note.order_id = $scope.selected_order_id;
        var json_url = base_url + "/api/order/note/save";

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.order_note), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
                $("#modalAddNote").modal("hide");
        });
    }

    $scope.ChangeStatus = function(order_id, status_id)
    {
        $("#modalLoadingData").modal("show");
        var json_url = base_url + "/ajax/orders/change_status?order_id=" + order_id + "&status_id=" + status_id;
        $http.get(json_url).success(function($data){
            $("#modalLoadingData").modal("hide");
            $scope.LoadOrders();
        });
    }

    $scope.LoadOrderStatuses = function()
    {
        var json_url = base_url + "/ajax/orders/status";
        $http.get(json_url).success(function($data){
            $scope.statuses = $data;
        });
    };
});