angular.module("WholeSale").controller("HomeController", function($scope, $http, $window){
    $scope.OrderProduct = function(quantity, product_id)
    {
        //if (typeof $quantity !== 'undefined' && $quantity != null)
        //{
            var json_url = base_url + "/api/products/add?id=" + product_id + "&quantity=" + quantity;
            $http.get(json_url).success(function($data){
                $("#total_items").text($data.total_items);
                alert_message('Cart', 'Cart updated');
            });
        //}
    };
});