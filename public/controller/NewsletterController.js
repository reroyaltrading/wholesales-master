angular.module("WholeSale").controller("NewsletterController", function($scope, $http, $window){
    $scope.templates = {};
    $scope.items_per_page = 25;
    $scope.current_page = 1;
    $scope.loading_templates = false;

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

    $scope.DeleteMail = function(id)
    {
        var json_url = base_url + "/api/mailling/mails/delete?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.LoadMails($scope.current_page);
        });
    }

    $scope.LoadBrands = function()
    {
        var json_url = base_url + "/api/mailling/mails/brands";
        $http.get(json_url).success(function($data){
            $scope.brands = $data;
        });   
    }

    $scope.LoadMails = function(page)
    {
        $scope.current_page = page;
        $scope.loading_users = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/api/mailling/mails/list?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.templates = $data.mails;
            $scope.total_pages = $data.total_pages;
            $scope.loading_users = false;
            $scope.items_per_page = $data.items_per_page;
        });    
    }

    $scope.OpenModalCreateMail = function()
    {
        $("#modalCreateEmail").modal("show");
    }

    $scope.EditMail = function(id)
    {
        var json_url = base_url + "/api/mailling/mails/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.mail = $data;
            $('.note-editable').html($data.content);
            $("#modalCreateEmail").modal("show");
        });
    }

    $scope.SaveMail = function()
    {
        $scope.mail.content = $('.note-editable').html();
        var post_url = base_url + "/api/mailling/mails/save";
        $http({
            method  : 'POST',
            url     : post_url,
            data    : $.param($scope.mail), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
               if($data.created)
               {
                    $("#modalCreateEmail").modal("hide");
               }
               $scope.LoadMails($scope.current_page);
           });

    }

    $scope.SendMail = function($template)
    {
        var $id = $template.id;
        $template.loading = true;
        var json_url = base_url + "/api/mailling/mails/send?id=" + $id;        
        $http.get(json_url).success(function($data){
             Swal.fire(
                 'Success!',
                 'Mail send sucessfully',
                 'success'
             ).then(
                 function () { 
                    $scope.LoadMails($scope.current_page);
                  },
                 function () { return false; });

            $template.loading = false;
        });
    }
});