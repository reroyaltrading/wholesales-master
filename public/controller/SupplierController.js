angular.module("WholeSale").controller("SupplierController", function($scope, $http, $window){
    $scope.suppliers = {};
    $scope.items_per_page = 25;
    $scope.current_page = 1;
    $scope.loading_suppliers = false;

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

    $scope.EditSupplierProducts = function(id)
    {
        $scope.editing_supplier_id = id;
        var json_url = base_url + "/api/suppliers/products/get?supplier_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.supplier_products = $data.products;
            $scope.supplier_products_not = $data.products_not;
            $("#modalSupplierProducts").modal('show');
        });
    }

    $scope.DeleteProductFromSupplier = function(product_id)
    {
        var supplier_id = $scope.editing_supplier_id;
        var json_url = base_url + "/api/suppliers/products/delete?supplier_id=" + supplier_id + "&product_id=" + product_id;
        $http.get(json_url).success(function($data){
            $scope.supplier_products = $data.products;
            $scope.supplier_products_not = $data.products_not;
        });
    }

    $scope.AddProductToSupplier = function()
    {
        var product_id = $scope.supplier_product_add_id;
        var supplier_id = $scope.editing_supplier_id;
        var json_url = base_url + "/api/suppliers/products/add?supplier_id=" + supplier_id + "&product_id=" + product_id;
        $http.get(json_url).success(function($data){
            $scope.supplier_products = $data.products;
            $scope.supplier_products_not = $data.products_not;
        });
    }

    $scope.OpenModalCreateSupplier = function()
    {
        $scope.supplier = {};
        $("#modalCreateSupplier").modal('show');
    }

    $scope.EditSupplier = function(id)
    {
        var json_url = base_url + "/api/suppliers/get?supplier_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.supplier = $data;
            $("#modalCreateSupplier").modal('show');
        });
    }

    $scope.SaveSupplier = function()
    {
        var json_url = base_url + "/api/suppliers/save";

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.supplier), 
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
               
                $scope.AdminListAllSuppliers($scope.current_page);
                $("#modalCreateSupplier").modal("hide");
                alert_message('Products', 'Supplier saved sucessfully');
          });
    }

    $scope.DeleteSupplier = function(id)
    {
        var json_url = base_url + "/api/suppliers/delete?supplier_id=" + id;
        $http.get(json_url).success(function($data){
            $scope.AdminListAllSuppliers($scope.current_page);
        });
    }
    
    $scope.AdminListAllSuppliers = function(page)
    {
        $scope.loading_suppliers = true;
        $scope.current_page = page;
        var items_per_page = $scope.items_per_page;
        var json_url = base_url + "/api/suppliers/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.suppliers = $data.suppliers;
            $scope.total_pages = $data.total_pages;
            $scope.loading_products = false;
            $scope.items_per_page = $data.items_per_page;
            $scope.loading_suppliers = false;
        });
    }
});
