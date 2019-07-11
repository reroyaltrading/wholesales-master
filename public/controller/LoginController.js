angular.module("WholeSale").controller("LoginController", function($scope, $http, $window){
    $scope.user = {};

    $scope.logging = false;
    $scope.loginTried = false;
    $scope.loginError = false; 
    $scope.recovery = {};
    $scope.recovering = false;
    $scope.user_recover = {};

    $scope.CompletePasswordRecovery = function()
    {
        if($scope.user_recover.password.length < 6 )
        {
            Swal.fire(
                'Error!',
                'Password minimun 6 characters!',
                'warning'
            );
        }
        else{
        $scope.user_recover.hash = $("#recovery_hash").val();
        var json_url = base_url + "/api/login/recovery/complete";
        //console.log($scope.user_recover);
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.user_recover), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
        }).success(function($data) {
            $scope.recovering = false;
            //if($data.created)
            //{
                Swal.fire(
                    'Success!',
                    'Password changed sucessfully!',
                    'success'
                ).then(
                    function () { 
                        window.location.href=base_url+"/index.html"
                        //window.href=base_url;
                     },
                    function () { return false; });

                $scope.user_recover = {};
            //}
        });
    }
    };

    $scope.RecoverAccount = function()
    {
        var json_url = base_url + "/api/login/recovery";
        $scope.recovering = true;
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.recovery), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
        }).success(function($data) {
            $scope.recovering = false;
            //if($data.created)
            //{
                Swal.fire(
                    'Success!',
                    'We sent an e-mail to you with a recovery link!',
                    'success'
                );
            //}
        });
    };
  
    $scope.DoLogin = function()
    {
      $scope.logging = true;
      var post_url = base_url + "/api/login";    
      console.log('logging');
  
  
        $http({
          method  : 'POST',
          url     : post_url,
          data    : $.param($scope.user), 
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
         }).success(function($data) {
          $scope.loginTried = true;
          $scope.loginError = !$data.auth;
          
          if($data.auth)
          {
            $window.location = base_url + ($data.user.ic_admin ? "admin/index.html" : "index.html");
            //$window.location.href = base_url + "/index.html";
            // Swal.fire(
            //     'Success!',
            //     'Logged sucessfully',
            //     'success'
            // ).then(
            //     function () { 
            //         $window.location.href = current_url;
            //      },
            //     function () { return false; });
            
          }
           else{
                 Swal.fire(
                     'Error!',
                     'Invalid user or password',
                     'error'
                 );
           }
  
          $scope.logging = false;
        });
    };
});