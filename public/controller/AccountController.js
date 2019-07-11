angular.module("WholeSale").controller("AccountController", function($scope, $http, $window){
    $scope.orders = {};
    $scope.loading_orders = false;
    $scope.creating_order = false;


    $scope.EditAccount = function(id)
    {
        var json_url = base_url + "/ajax/accounts/user_by_id?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.user = $data;
            $scope.LoadStates();
            $("#modalAccount").modal("show");
        });
    };

    $scope.LoadOrders = function()
    {
        $scope.loading_orders = true;
        var json_url = base_url + "/ajax/accounts/orders";
        $http.get(json_url).success(function($data){
            $scope.orders = $data;
            $scope.loading_orders = false;
        });
    };

    $scope.RemoveProductFromOrder = function(order_id, product_id)
    {
        var json_url = base_url + "/api/account/order/removeproduct?order_id="+order_id+"&product_id="+product_id;
        $http.get(json_url).success(function($data){
            Swal.fire(
                $data.deleted ? 'Success!' : 'Error',
                $data.text,
                $data.deleted ? 'success' : 'error'
            ).then(
                function () { 
                    if($data.deleted)
                    {
                        window.location.href=$("#current_url").val();
                    }
                 },
                function () { return false; });
        });
    }

    $scope.ContactSupplier = function()
    {
        $("#modalContactAccount").modal("show");
    }

    $scope.SendContact = function(id)
    {
        $scope.contact.order_id = id;
        var json_url = base_url + "/api/order/contact/send";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.contact), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
        }).success(function($data) {
            if($data.created)
            {
                $scope.contact = {};
            }
            $("#modalContactAccount").modal("hide");
        });
    }

    $scope.LoadContactMessages = function(id)
    {
        var json_url = base_url + "/api/order/contact/getall?order_id="+id;
        $http.get(json_url).success(function($data){
            $("#modalMessages").modal('show');
            $scope.messages = $data;
        });
    }

    $scope.SaveAccount = function()
    {
        var json_url = base_url + "/api/user/save";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.user), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
            $("#modalAccount").modal("hide");
          });
    }

    $scope.LoadCountries = function()
    {
        var json_url = base_url + "/ajax/countries/getall";
        $http.get(json_url).success(function($data){
            $scope.countries = $data;
        });
    };

    $scope.LoadStates = function()
    {        
        var json_url = base_url + "/ajax/country/getstates?id=" + $scope.user.country_id;
        $http.get(json_url).success(function($data){
            $scope.states = $data;
        });
    };

    $scope.RemakeOrder = function(order)
    {
        var id = order.id;
        order.creating_order = true;
        var json_url = base_url + "/ajax/accounts/orders/remake?id=" + id;
        $http.get(json_url).success(function($data){
            Swal.fire(
                'Success!',
                'Order was replied successfully',
                'success'
            ).then(
                function () { 
                    order.creating_order = false;
                    $scope.LoadOrders();
                 },
                function () { return false; });
        });
    };

    $scope.DisableOrder = function(id)
    {
        var json_url = base_url + "/ajax/accounts/orders/disable?id=" + id;
        $http.get(json_url).success(function($data){
            Swal.fire(
                'Success!',
                'Order was deleted successfully',
                'success'
            ).then(
                function () { 
                    $scope.LoadOrders();
                 },
                function () { return false; });
            
        });
    };
});