angular.module("WholeSale").controller("MailMarketingController", function($scope, $http, $window){
    $scope.marketing = {};
    $scope.sending_mail = false;
    //marketing.email

    $scope.RegisterNewsLetter = function()
    {
        $scope.sending_mail = true;
        var json_url = base_url + "/api/mail/marketing";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.marketing), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
            Swal.fire(
                'Success!',
                'You have been subscribed to our newsletter',
                'success'
            ).then(
                function () { 
                    $scope.marketing = {};
                 },
                function () { return false; });

            $scope.sending_mail = false;
        });
    }
});