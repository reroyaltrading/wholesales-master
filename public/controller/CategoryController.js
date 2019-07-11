angular.module("WholeSale").controller("CategoryController", function($scope, $http, $window){
    $scope.categories = {};
    $scope.saving = false;
    $scope.has_error = false;
    $scope.loading_categories = false;
    $scope.items_per_page = 25;
    
    $scope.OpenModalCreateCategory = function()
    {
        $scope.has_error = false;
        $scope.category = {};
        $("#modalCreateCategory").modal('show');
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

    $scope.DeleteCategory = function(id)
    {
        var json_url = base_url + "/api/categories/delete?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.AdminListAllCategories($scope.current_page);
        });
    }

    $scope.SaveCategory = function()
    {
        var json_url = base_url + "/api/categories/save";
        $scope.saving = true;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.category), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           })
           .then(function successCallback(response) {
                $scope.errors = response.data.errors;
                $scope.saving = false;
                $scope.has_error = !response.created;
                $scope.message = response.data.message;

                if(response.data.created)
                {
                    $scope.AdminListAllCategories($scope.current_page);
                    $("#modalCreateCategory").modal("hide");
                    alert_message('Category', 'Category saved sucessfully');
                }
          }, function errorCallback(response) {
                $scope.errors = response.data.errors;
                $scope.has_error = true;
                $scope.saving = false;
                $scope.error_message = response.data.message;
          });
    };

    $scope.EditCategory = function(id)
    {
        $scope.has_error = false;
        var json_url = base_url + "/api/categories/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.category = $data;
            $("#modalCreateCategory").modal("show");            
        });
    }

    $scope.AdminListAllCategories = function(page)
    {
        $scope.current_page = page;
        $scope.loading_categories = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/api/categories/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.categories = $data.categories;
            $scope.total_pages = $data.total_pages;
            $scope.loading_categories = false;
            $scope.items_per_page = $data.items_per_page;
        });
    }
});