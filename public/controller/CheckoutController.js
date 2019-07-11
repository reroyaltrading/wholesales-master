angular.module("WholeSale").controller("CheckoutController", function($scope, $http, $window){
   
    $scope.SaveOrder = function()
    {
        $scope.order = {};
        $scope.order.phone_number = $("#phone_number").val();
        $scope.order.first_name = $("#first_name").val();
        $scope.order.last_name = $("#last_name").val();
        $scope.order.company_name = $("#company_name").val();
        $scope.order.email = $("#email").val();
        $scope.order.address = $("#address").val();
        $scope.order.address2 = $("#address2").val();
        $scope.order.country = $("#country").val();
        $scope.order.zip_code = $("#zip_code").val();
        $scope.order.same_address = $("#same_address").val();
        $scope.order.receive_quote_monthly = $("#receive_quote_monthly").val();
        $scope.order.payment_credit_card = $("#payment_credit_card").val();
        $scope.order.payment_debit_card = $("#payment_debit_card").val();
        $scope.order.payment_paypal = $("#payment_paypal").val();
        $scope.order.payment_cash = $("#payment_cash").val();
        $scope.order.payment_cash = $("#payment_other").val();

        var json_url = base_url + "/api/checkout/order/save";

        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.order), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
                $scope.saving = false;
                alert_message('Cart', 'Cart saved');
          });

    };
});