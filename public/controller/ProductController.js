angular.module("WholeSale").controller("ProductController", function($scope, $http, $window){

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

    $scope.on_wish_list = false;
    $scope.product_quantity = 1;
    $scope.products = {};
    $scope.total_price = 0;
    $scope.cart = {};   
    $scope.loading_purchase = false;
    $scope.contact = {};
    $scope.sending_contact = false;
    $scope.items_per_page = 25;

    $scope.OpenSuppierForm = function()
    {
        $scope.contact = {};
        $("#modalSupplierContact").modal("show");
    }

    $scope.SendContactInfo = function()
    {
        $scope.sending_contact = true;
        var json_url = base_url + "/api/contact/save";
        
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.contact), 
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
           }).success(function($data) {
               if($data.created)
               {
                $("#modalSupplierContact").modal("hide");
                $scope.sending_contact = false;
                alert_message('Contact', 'Contact saved sucessfully');
               }
          });
    };

    $scope.DeleteProduct = function(id)
    {
        var json_url = base_url + "/api/products/disable?id=" + id;
        $http.get(json_url).success(function($data){
            if($data.created)
            {
                Swal.fire(
                    'Success!',
                    'Order was replied successfully',
                    'success'
                ).then(
                    function () { 
                        $scope.AdminListAllProducts();
                     },
                    function () { return false; });
            }
        });
    }

    $scope.ProceedPurchase = function()
    {
        $scope.loading_purchase = true;
        var json_url = base_url + "/ajax/purchase/order/save";
        $http.get(json_url).success(function($data){
            if($data.created)
            {

                window.location = "account.html";
            }
        });
    };

    $scope.EditProductImages = function(id)
    {
        $scope.current_product_id = id;
        var json_url = base_url + "/api/products/pictures/getall?id=" + id;
        $http.get(json_url).success(function($data){
            $("#modalPictures").modal("show");
            $scope.pictures = $data;
        });
    }

    $scope.LoadPictures = function(id)
    {
        var json_url = base_url + "/api/products/pictures/getall?id=" + id;
        $http.get(json_url).success(function($data){
            $("#modalPictures").modal("show");
            $scope.pictures = $data;
        });
    }

    $scope.RemoveFileByName = function(name)
    {
        var json_url = base_url + "/api/products/pictures/remove?name=" + name;
        $http.get(json_url).success(function($data){
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

    $scope.AdminListAllProducts = function(page)
    {
        $scope.current_page = page;
        $scope.loading_products = true;

        var items_per_page = $scope.items_per_page;

        var json_url = base_url + "/api/products/listall?page=" + page + "&items_per_page=" + items_per_page;
        $http.get(json_url).success(function($data){
            $scope.products = $data.products;
            $scope.total_pages = $data.total_pages;
            $scope.loading_products = false;
            $scope.items_per_page = $data.items_per_page;
        });
    };

    $scope.CheckIfProductIsOnWishList = function($id)
    {
        var json_url = base_url + "/api/products/is_on_wish_list?id=" + $id;
        $http.get(json_url).success(function($data){
            $scope.on_wish_list = $data.on_list;
            $("#wishlistcontent").html($scope.on_wish_list ? "Remove from Wishlist" : "Add Wishlist");
            $("#total_items_wish_list").text($data.total_items);
        });
    }

    $scope.AddWishList = function($id)
    {
        var json_url = base_url + ( $scope.on_wish_list ? "/api/products/remove_wish_list?id=" : "/api/products/add_wish_list?id=") + $id;
        $http.get(json_url).success(function($data){
            $scope.on_wish_list = !$scope.on_wish_list;

            $("#wishlistcontent").html($scope.on_wish_list ? "Remove from Wishlist" : "Add Wishlist");
            alert_message('Products', $scope.on_wish_list ? 'Product added to your wishlist sucessfully' : 'Product removed from your wishlist sucessfully');
            $("#total_items_wish_list").text($data.total_items);
        });
    }

    $scope.AddProduct = function($id)
    {
        $scope.product_quantity = $("#selected_quantity").val();
        if (typeof $scope.product_quantity !== 'undefined' && $scope.product_quantity != null)
        {
            var json_url = base_url + "/api/products/add?id=" + $id + "&quantity=" + $scope.product_quantity;
            $http.get(json_url).success(function($data){
                alert_message('Products', 'Product added to your cart sucessfully');
                $("#total_items").text($data.total_items);
            });
        }
    };

    $scope.ChangeImageOfProduct = function(source)
    {
        console.log("image changed");        
        $('#imageSourceRef').attr('href', source);
        $('#imageSource').attr('src', source);
    };
    
    $scope.DeletePicture = function(id)
    {
        var json_url = base_url + "/api/products/pictures/delete?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.LoadPictures($scope.current_product_id);
        });
    }

    $scope.EditProduct = function(id)
    {
        dZUpload[0].dropzone.removeAllFiles();
        
        if (typeof Dropzone.options.dropzone_test !== 'undefined' && Dropzone.options.dropzone_test != null)
        {
            Dropzone.options.dropzone_test.removeAllFiles();
        }

        var json_url = base_url + "/api/products/get?id=" + id;
        $http.get(json_url).success(function($data){
            $scope.LoadCategories();
            $scope.LoadTypes();
            $scope.has_error = false;
            $scope.product = $data;
            $('.note-editable').html($data.cold_description);
            $("#modalCreateProduct").modal("show");            
        });
    };

    $scope.OpenModalCreateProduct = function()
    {
        dZUpload[0].dropzone.removeAllFiles();
        if (typeof Dropzone.options.dropzone_test !== 'undefined' && Dropzone.options.dropzone_test != null)
        {
            Dropzone.options.dropzone_test.removeAllFiles();
        }
        $scope.has_error = false;
        $scope.product = {};
        $scope.LoadCategories();
        $scope.LoadTypes();
        $("#modalCreateProduct").modal("show");
    };

    $scope.SaveProduct = function()
    {
        var json_url = base_url + "/api/products/save";
        $scope.product.cold_description = $('.note-editable').html();
        
        $http({
            method  : 'POST',
            url     : json_url,
            data    : $.param($scope.product), 
          headers : { 'Content-Type': 'application/x-www-form-urlencoded' } 
        }).then(function successCallback(response) {
            $scope.errors = response.data.errors;
            $scope.saving = false;
            $scope.has_error = !response.created;

            if(response.data.created)
            {
                $scope.AdminListAllProducts($scope.current_page);
                $("#modalCreateProduct").modal("hide");
                alert_message('Products', 'Product saved sucessfully');
            }
      }, function errorCallback(response) {
            $scope.errors = response.data.errors;
            $scope.error_message = response.data.message;
            $scope.has_error = true;
            $scope.saving = false;
      });

    }

    $scope.LoadCategories = function()
    {
        var json_url = base_url + "/api/products/categories";
        $http.get(json_url).success(function($data){
            $scope.categories = $data;
        });
    }

    $scope.LoadTypes = function()
    {
        var json_url = base_url + "/api/products/types";
        $http.get(json_url).success(function($data){
            $scope.types = $data;
        });
    }

    $scope.UpdateOn = function($product)
    {
        if($product.quantity < 0)
        {
            $product.quantity = 1;
        }

        $product.sub_price = $product.price * $product.quantity;
        var total = 0;

        for(var i = 0; i < $scope.products.length; i++){
            var product = $scope.products[i];
            total += (product.price * product.quantity);
        }

        $scope.total_price = total;
    };

    $scope.SaveCart = function()
    {
        $scope.saving = true;
        var json_url = base_url + "/api/products/shopping/save";
        $scope.cart.products = $scope.products;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : 
            {
               'cart' : $scope.cart.products
            }, 
            headers : { 'Content-Type': 'application/json' } 
           }).success(function($data) {
                $scope.saving = false;
                $scope.products = $data.products;
                $scope.total_price = $data.total;
                alert_message('Cart', 'Cart saved');
          });
    }
    
    $scope.RemoveFromShoppingCart = function($id)
    {
        var json_url = base_url + "/api/products/shopping/save";

        $scope.cart.products = $scope.products;

        $http({
            method  : 'POST',
            url     : json_url,
            data    : {
                'cart' : $scope.cart.products
             }, 
            headers : { 'Content-Type': 'application/json' } 
        }).success(function($data) {
            $scope.RemoveProduct($id);
        });
    }


    $scope.RemoveProduct = function($id)
    {
        $scope.SaveCart();
        var json_url = base_url + "/api/products/shopping/remove?id=" + $id;
        $http.get(json_url).success(function($data){
            $scope.products = $data.products;
            $scope.total_price = $data.total;
        });    
    }

    $scope.LoadShoppingCart = function()
    {
        var json_url = base_url + "/api/products/shopping/list";
        $http.get(json_url).success(function($data){
            $scope.products = $data.products;
            $scope.total_price = $data.total;
        });    
    }
});