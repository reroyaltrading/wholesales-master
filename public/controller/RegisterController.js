angular.module("WholeSale").controller("RegisterController", function($scope, $http, $window){
    $scope.saving = false;
    $scope.user = {};

    $scope.LoadStates = function()
    {        
        var json_url = base_url + "/ajax/country/getstates?id=" + $scope.user.country_id;
        $http.get(json_url).success(function($data){
            $scope.states = $data;
        });
    };

    $scope.ValidatePasswords = function()
    {
        if($scope.user.password != $scope.user.repeat)
        {
            $scope.password_error = "Two passwords are not equal";
            $scope.wrongpassword = true;
        }else if($scope.user.password.length < 6 )
        {
            $scope.password_error = "Choose a stronger password (at least 6 characters)";
            $scope.wrongpassword = true;
        }else{
            $scope.wrongpassword = false;
        }
    }

    $scope.NameIsComplete = function(name)
    {
        console.log(name.split(' '));
        return name.split(' ').length > 1;
    }
    
    $scope.RegisterUser = function()
    {
        var name = $scope.user.name;
        if(!$scope.NameIsComplete(name))
        {
            $scope.Wrongpassword=false;
            Swal.fire('Please, check your name!');
        }
        else{
        $scope.saving = true;
        var json_url = base_url + "/api/user/register";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.user), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
                $scope.saving = false;
                $scope.user = {};
                Swal.fire(
                    $data.title,
                    $data.warning,
                    $data.alert
                ).then(
                    function () { 
                        $window.location = base_url;
                     },
                    function () { return false; });
          });
        }
    };
});