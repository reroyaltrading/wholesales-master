angular.module("WholeSale").controller("UserController", function($scope, $http, $window){
    $scope.users = {};
    $scope.saving = false;
    
    $scope.user_editing = 0;
    $scope.id_category = 0;

    $scope.adding_category = false;
    $scope.items_per_page = 25;
    $scope.loading_users = false;

    $scope.current_page = 0;

    $scope.AdminListAllUsers = function(page = 0)
    {
        $scope.current_page = page;
        $scope.loading_users = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/ajax/users/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.users = $data.users;
            $scope.total_pages = $data.total_pages;
            $scope.loading_users = false;
            $scope.items_per_page = $data.items_per_page;
        });    
    };

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

    $scope.LoadUserBrands = function()
    {
        var json_url = base_url + "/api/users/brands?id=" + $scope.user_editing;
        $http.get(json_url).success(function($data){
            $scope.brands_have = $data.brands_have;
            $scope.brands_not = $data.brands_not;
        });
    }

    $scope.EditUserBrands = function(id)
    {
        var json_url = base_url + "/api/users/brands?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.brands_have = $data.brands_have;
            $scope.brands_not = $data.brands_not;
            $scope.user_editing = id;
            $("#modalEditBrands").modal("show");
        }); 
    }

    $scope.DeleteBrandUser = function($brand_id)
    {
        var json_url = base_url + "/api/users/brands/delete?user_id=" + $scope.user_editing + "&brand_id=" + $brand_id;
        $http.get(json_url).success(function($data){
            $scope.LoadUserBrands();
        });
    }

    $scope.AddBrandUser = function()
    {
        $scope.adding_brand = true;
        var json_url = base_url + "/api/users/brands/add?user_id=" + $scope.user_editing + "&brand_id=" + $scope.id_brand;
        $http.get(json_url).success(function($data){
            $scope.LoadUserBrands();
            $scope.adding_brand= false;
        });
    }

    $scope.EditUserCategories = function(id)
    {
        var json_url = base_url + "/api/users/categories?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.categories_have = $data.categories_have;
            $scope.categories_not = $data.categories_not;
            $scope.user_editing = id;
            $("#modalEditCategories").modal("show");
        }); 
    };

    $scope.LoadUserCategories = function()
    {
        var json_url = base_url + "/api/users/categories?id=" + $scope.user_editing;
        $http.get(json_url).success(function($data){
            $scope.categories_have = $data.categories_have;
            $scope.categories_not = $data.categories_not;
        });
    };

    $scope.DeleteCategoryUser = function($category_id)
    {
        var json_url = base_url + "/api/users/categories/delete?user_id=" + $scope.user_editing + "&category_id=" + $category_id;
        $http.get(json_url).success(function($data){
            $scope.LoadUserCategories();
        });
    }

    $scope.AddCategoryUser = function()
    {
        if($scope.id_category == 0 || $scope.id_category == null)
        {
            Swal.fire(
                'Error!',
                'Invalid request!',
                'warning'
            );
        }else
        {
        $scope.adding_category = true;
        }
        var json_url = base_url + "/api/users/categories/add?user_id=" + $scope.user_editing + "&category_id=" + $scope.id_category;
        $http.get(json_url).success(function($data){
            $scope.LoadUserCategories();
            $scope.adding_category = false;
        });
    }

    $scope.SaveUser = function()
    {
        $scope.saving = true;
        var json_url = base_url + "/ajax/users/save";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.user), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
                $scope.saving = false;
                $scope.AdminListAllUsers();
                $("#modalCreateUser").modal("hide");
                alert_message('User', 'user saved');
          });
    }

    $scope.EditUser = function(id)
    {
        var json_url = base_url + "/ajax/users/getone?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.user = $data;
            $scope.LoadStates();
            $("#modalCreateUser").modal("show");
        }); 
    }

    $scope.LoadStates = function()
    {        
        var json_url = base_url + "/ajax/country/getstates?id=" + $scope.user.country_id;
        $http.get(json_url).success(function($data){
            $scope.states = $data;
        });
    };

    $scope.LoadCountries = function()
    {
        var json_url = base_url + "/ajax/countries/getall";
        $http.get(json_url).success(function($data){
            $scope.countries = $data;
        });
    };

    $scope.CreateUser = function()
    {
        $("#modalCreateUser").modal("show");
        $scope.user = {};
    }
});
