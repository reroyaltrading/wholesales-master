angular.module("WholeSale").controller("OrderStatusController", function($scope, $http, $window){
    $scope.statuses = {};
    $scope.saving = false;
    $scope.has_error = false;
    $scope.loading_statuses = false;
    $scope.items_per_page = 25;
    
    $scope.OpenModalCreateStatus = function()
    {
        $scope.has_error = false;
        $scope.status = {};
        $("#modalCreateStatus").modal('show');
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

    $scope.DeleteStatus = function(id)
    {
        var json_url = base_url + "/api/orders/statuses/delete?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.AdminListAllStatuses($scope.current_page);
        });
    }

    $scope.SaveStatus = function()
    {
        var json_url = base_url + "/api/orders/statuses/save";
        $scope.saving = true;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.status), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           })
           .then(function successCallback(response) {
                $scope.errors = response.data.errors;
                $scope.saving = false;
                $scope.has_error = !response.created;
                $scope.message = response.data.message;

                if(response.data.created)
                {
                    $scope.AdminListAllStatuses($scope.current_page);
                    $("#modalCreateStatus").modal("hide");
                    alert_message('Order Status', 'Order status saved sucessfully');
                }
          }, function errorCallback(response) {
                $scope.errors = response.data.errors;
                $scope.has_error = true;
                $scope.saving = false;
                $scope.error_message = response.data.message;
          });
    };

    $scope.EditStatus = function(id)
    {
        $scope.has_error = false;
        var json_url = base_url + "/api/orders/statuses/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.status = $data;
            $("#modalCreateStatus").modal("show");            
        });
    }

    $scope.AdminListAllStatuses = function(page)
    {
        $scope.current_page = page;
        $scope.loading_statuses = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/api/orders/statuses/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.statuses = $data.statuses;
            $scope.total_pages = $data.total_pages;
            $scope.loading_statuses = false;
            $scope.items_per_page = $data.items_per_page;
        });
    }
});

angular.module("WholeSale").controller("BrandController", function($scope, $http, $window){
    $scope.brands = {};
    $scope.loading_brands = {};
    $scope.current_page = 0;
    $scope.items_per_page = 25;
    $scope.page = 0;
    $scope.saving = false;
    $scope.errors = {};

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

    $scope.DeleteBrand = function(id)
    {
        var json_url = base_url + "/api/brands/delete?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.AdminListAllBrands($scope.current_page);
        });
    }

    $scope.SaveBrand = function()
    {
        var json_url = base_url + "/api/brands/save";
        $scope.saving = true;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.brand), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           })
           .then(function successCallback(response) {
                $scope.errors = response.data.errors;
                $scope.saving = false;
                $scope.has_error = !response.created;
                $scope.message = response.data.message;

                if(response.data.created)
                {
                    $scope.AdminListAllBrands($scope.current_page);
                    $("#modalCreateBrand").modal("hide");
                    alert_message('Brands', 'Brand saved sucessfully');
                }
          }, function errorCallback(response) {
                $scope.errors = response.data.errors;
                $scope.has_error = true;
                $scope.saving = false;
                $scope.error_message = response.data.message;
          });
    };

    $scope.EditBrand = function(id)
    {
        $scope.has_error = false;
        var json_url = base_url + "/api/brands/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.brand = $data;
            $("#modalCreateBrand").modal("show");            
        });
    }

    $scope.OpenModalCreateBrand = function()
    {
        $scope.has_error = false;
        $scope.brand = {};
        $("#modalCreateBrand").modal("show");
    }

    $scope.AdminListAllBrands = function(page)
    {
        $scope.current_page = page;
        $scope.loading_brands = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/api/brands/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.brands = $data.brands;
            $scope.total_pages = $data.total_pages;
            $scope.loading_brands = false;
            $scope.items_per_page = $data.items_per_page;
        });
    };
});
