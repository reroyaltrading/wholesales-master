angular.module("WholeSale").controller("DiscountController", function($scope, $http, $window){
    $scope.discounts = {};
    $scope.loading_discounts = false;
    $scope.creating_discounts = false;
    $scope.items_per_page = 25;
    $scope.current_page = 1;
    $scope.discount = {};

    $scope.LoadDiscounts = function(page)
    {
        $scope.current_page = page;
        var items_per_page = $scope.items_per_page;
        var json_url = base_url + "/api/discounts/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.discounts = $data.discounts;
            $scope.total_pages = $data.total_pages;
            $scope.loading_products = false;
            $scope.items_per_page = $data.items_per_page;
        });
    };

    $scope.GetDataFromDiscount = function(id)
    {
        var json_url = base_url + "/api/discounts/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.discount = $data.discount;
            $scope.brands = $data.brands;
            $scope.clients = $data.clients;
            $scope.clients = $data.categories;
        });
    }

    $scope.AddCategory = function(id)
    {
        var json_url = base_url + "/api/discounts/categories/not?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.categories_not = $data;
            $("#modalAddCategory").modal("show");
        });
    }

    $scope.AddClient = function(id)
    {
        var json_url = base_url + "/api/discounts/clients/not?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.clients_not = $data;
            $("#modalAddClient").modal("show");
        });
    }

    $scope.AddBrand = function(id)
    {
        var json_url = base_url + "/api/discounts/brands/not?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.brands_not = $data;
            $("#modalAddBrand").modal("show");
        });
    }

    $scope.FinishAddProduct = function(id)
    {
        var json_url = base_url + "/api/discounts/brands/add?id=" + id + "&brand_id=" + $scope.selected_brand_id;
        $http.get(json_url).success(function($data){
            $scope.LoadBrands(id);
            $("#modalAddBrand").modal("hide");
        });
    }

    $scope.FinishAddClient = function(id)
    {
        var json_url = base_url + "/api/discounts/clients/add?id=" + id + "&client_id=" + $scope.selected_client_id;
        $http.get(json_url).success(function($data){
            $scope.LoadClients(id);
            $("#modalAddClient").modal("hide");
        });
    }

    $scope.FinishAddCategory = function(id)
    {
        var json_url = base_url + "/api/discounts/categories/add?id=" + id + "&category_id=" + $scope.selected_category_id;
        $http.get(json_url).success(function($data){
            $scope.LoadCategories(id);
            $("#modalAddCategory").modal("hide");
        });
    }

    $scope.LoadClients = function(id)
    {
        var json_url = base_url + "/api/discounts/clients/list?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.clients = $data;
        });
    }

    $scope.LoadCategories = function(id)
    {
        var json_url = base_url + "/api/discounts/categories/list?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.categories = $data;
        });
    }

    $scope.LoadBrands = function(id)
    {
        var json_url = base_url + "/api/discounts/brands/list?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.brands = $data;
        });
    }

    $scope.RemoveCategory = function(id, category_id)
    {
        var json_url = base_url + "/api/discounts/categories/delete?id=" + id + "&category_id=" + category_id;
        $http.get(json_url).success(function($data){
            $scope.categories = $data;
        });
    }

    $scope.RemoveClient = function(id, client_id)
    {
        var json_url = base_url + "/api/discounts/clients/delete?id=" + id + "&client_id=" + client_id;
        $http.get(json_url).success(function($data){
            $scope.clients = $data;
        });
    }

    $scope.RemoveBrand = function(id, brand_id)
    {
        var json_url = base_url + "/api/discounts/brands/delete?id=" + id + "&brand_id=" + brand_id;
        $http.get(json_url).success(function($data){
            $scope.brands = $data;
        });
    }

    $scope.SaveDiscount = function(id)
    {
        var json_url = base_url + "/api/discounts/save";
        $scope.saving = true;
        $scope.discount.id = id;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.discount), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           })
           .then(function successCallback(response) {
                $scope.saving = false;
          }, function errorCallback(response) {
                $scope.saving = false;
          });
    }
    
});

