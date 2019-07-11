angular.module("WholeSale").controller("FavoriteController", function($scope, $http, $window){
    $scope.favorites = {};

    $scope.GetFavorites = function(user_id)
    {
        var json_url = base_url + "/api/users/getfavorites?id=" + user_id;
        $http.get(json_url).success(function($data){
            $scope.favorites = $data;
            $("#modalFavorites").modal("show");
        });
    }

    $scope.LoadFavorites = function($user_id)
    {
        var json_url = base_url + "/api/users/getfavorites?id=" + $user_id;
        $http.get(json_url).success(function($data){
            $scope.favorites = $data;
        });
    }

    $scope.RemoveFromWishList = function($id, $user_id)
    {
        var json_url = base_url + "/api/products/remove_wish_list?id=" + $id; 
        $http.get(json_url).success(function($data){
            $scope.LoadFavorites($user_id);
        });
    }

    $scope.CheckIfProductIsOnWishList = function($id)
    {
        var json_url = base_url + "/api/products/is_on_wish_list?id=" + $id;
        $http.get(json_url).success(function($data){
            $scope.on_wish_list = $data.on_list;
            $("#wishlistcontent").html($scope.on_wish_list ? "Remove from Wishlist" : "Add Wishlist");
            $("#total_items_wish_list").text($data.total_items);
        });
    }
});