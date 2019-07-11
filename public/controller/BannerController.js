angular.module("WholeSale").controller("BannerController", function($scope, $http, $window){
    $scope.current_page = 0;
    $scope.items_per_page = 25;
    $scope.loading_banners = false;

    var dropzone_url = $("#dropzone_url").val();
    var dZUpload = $("#dropzone_test").dropzone(
        { 
            url: dropzone_url,
            addRemoveLinks: true,
            maxFiles:10,
            init: function() {
                this.on("removefile", function(file) {
                    if (currentFile) {
                        this.removeFile(currentFile);
                    }
                    currentFile = file;
                });
            },
            removedfile: function(file) {
                file.previewElement.remove();
                $scope.RemoveFileByName(file.name);
            }
        }
    );

    $scope.DeleteBanner = function(id)
    {
       var json_url = base_url + "/api/banners/delete?id=" + id;
       $http.get(json_url).success(function($data){
            $scope.AdminListAllBanners($scope.current_page);
       });
    }

    $scope.EditBanner = function(id)
    {
        var  json_url = base_url + "/api/banners/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.banner = $data;
            dZUpload[0].dropzone.removeAllFiles();
            $("#modalCreateBanner").modal("show");
        });
    }

    $scope.RemoveFileByName = function(name)
    {

    }

    $scope.SaveBanner = function()
    {
        $scope.saving = true;
        var json_url = base_url + "/api/banners/save";
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.banner), 
            headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
                $scope.saving = false;
                $scope.AdminListAllBanners($scope.current_page);
                $("#modalCreateBanner").modal("hide");
                alert_message('Banner', 'banner saved');
          });
    }

    $scope.AdminListAllBanners = function(page)
    {
        $scope.loading_banners = true;
        $scope.page = page;
        var json_url = base_url + "/api/banners/listall?page=" + page + "&items_per_page=" + $scope.items_per_page; 
        $http.get(json_url).success(function($data){
            $scope.banners = $data.banners;
            $scope.total_pages = $data.total_pages;
            $scope.loading_banners = false;
            $scope.items_per_page = $data.items_per_page;
        });  
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


    $scope.OpenModalCreateBanner = function()
    {
        $scope.banner = {};
        dZUpload[0].dropzone.removeAllFiles();
        $("#modalCreateBanner").modal("show");
    }
});
