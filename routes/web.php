<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('shopping_index');
})->name("home_index");


Route::get('/404.html', function () {
    return view('error.error404');
});

/* EXCEL */
Route::get('/export/orders', 'ExcelController@export_order')->name('export_order');
Route::get('/export/contacts', 'ExcelController@export_contacts')->name('export_contacts');

Route::get('/shopping.html', 'HomeController@home_index')->name("shopping_index");
Route::get('/shopping/product/{route}.html', 'ProductController@product_detail')->name('product_detail');
Route::get('/shopping/category/{id}/products.html', 'HomeController@home_category_index')->name("home_category_index");
Route::get('/shopping/checkout.html', 'CheckoutContoller@checkout_index')->name('checkout_index');
Route::get('/shopping/checkout/finalizing.html', 'CheckoutContoller@finalize_checkout')->name('finalize_checkout');
Route::get('/shopping/account.html', 'AccountController@account_index')->name('account_index');

Route::get('/admin/index.html', 'AdminController@admin_index')->name('admin_console');

Route::get('/admin/logistics/suppliers.html', 'SupplierController@suppliers_index')->name('suppliers_index');
Route::get('/admin/logistics/products.html', 'ProductController@product_admin_index')->name('products_index_console');

route::get('/ajax/items/list', 'WarehouseController@warehouse_list_items')->name('warehouse_list_items');
route::get('/api/orders/items/{id}', 'ApiController@api_list_items')->name('api_list_items');
route::get('/api/orders/list', 'ApiController@ajax_list_orders')->name('ajax_list_orders');
route::get('/admin/logistics/warehousing/{id}.html', 'WarehouseController@warehouse_index')->name('warehouse_index');

Route::get('/admin/customers/contacts.html', 'ContactController@contact_index')->name('contact_index');
Route::get('/admin/customers/newsletters.html', 'NewsletterController@news_index')->name('news_index');

Route::get('/admin/directory/users.html', 'UserController@users_index')->name('users_index');

Route::get('/admin/marketing/brands.html', 'BrandController@brand_index')->name('brand_index');
Route::get('/admin/marketing/categories.html', 'CategoryController@category_index')->name('category_index');
Route::get('/admin/marketing/banner.html', 'BannerController@banner_index')->name('banner_index');

Route::get('/password-recovery.html', 'LoginContoller@recover_index')->name('recover_index');
Route::get('/account/recovery/confirm/{hash}', 'LoginContoller@recover_confirm_index')->name('recover_confirm_index');
Route::get('/account/verify/{hash}', 'LoginContoller@verify_account');
Route::get('/refund-policy.html', 'RefundController@refund_index')->name('refund_index');
Route::get('/help-center.html', 'HelpController@help_index')->name('help_index');
Route::get('/mailling/unsubscribe/{hash}', 'HomeController@unsubscribe_email')->name('unsubscribe_email');

Route::get('/account/orders/{id}', 'AccountController@acount_index_order')->name('acount_index_order');

Route::get('supplier/contact.html', 'ProductController@contact_supplier')->name('contact_supplier');
Route::get('privacy-policy.html', function(){
    return view('privacy.index');
})->name('privacy_policy');

Route::get('/login.html', 'LoginContoller@login_index')->name("login");
Route::get('/index.html', 'HomeController@home_index')->name("home_index_html");

/* MODULE ORDER COSTS */

Route::get('/admin/purchases/orders/costs/{id}', 'OrderCostsController@orders_costs_index')->name('orders_costs_index');
Route::get('/admin/purchases/orders/view/{id}', 'OrderController@orders_get_index')->name('orders_get_index');
Route::get('/admin/purchases/orders.html', 'OrderController@orders_index')->name('orders_index');

Route::get('/api/orders/costs/get', 'OrderCostsController@ajax_order_costs_get')->name('ajax_order_costs_get');
Route::post('/api/orders/costs/save', 'OrderCostsController@ajax_order_costs_save')->name('ajax_order_costs_save');
Route::get('/api/orders/costs/list', 'OrderCostsController@ajax_order_costs_list')->name('ajax_order_costs_list');
Route::get('/api/orders/costs/delete', 'OrderCostsController@ajax_order_costs_delete')->name('ajax_order_costs_delete');

/* MODULE DISCOUNTS */

Route::get('/api/discounts/categories/not', 'DiscountController@ajax_discounts_categories_not')->name('ajax_discounts_categories_not');
Route::get('/api/discounts/categories/add', 'DiscountController@ajax_discounts_categories_add')->name('ajax_discounts_categories_add');
Route::get('/api/discounts/categories/list', 'DiscountController@ajax_discounts_categories_list')->name('ajax_discounts_categories_list');
Route::get('/api/discounts/categories/delete', 'DiscountController@ajax_discounts_categories_delete')->name('ajax_discounts_categories_delete');

Route::get('/api/discounts/clients/delete', 'DiscountController@ajax_discounts_clients_delete')->name('ajax_discounts_clients_delete');
Route::get('/api/discounts/clients/list', 'DiscountController@ajax_discounts_clients_list')->name('ajax_discounts_clients_list');
Route::get('/api/discounts/clients/not', 'DiscountController@ajax_discounts_clients_not')->name('ajax_discounts_clients_not');
Route::get('/api/discounts/clients/add', 'DiscountController@ajax_discounts_clients_add')->name('ajax_discounts_clients_add');

Route::get('/api/discounts/brands/delete', 'DiscountController@ajax_discounts_brands_delete')->name('ajax_discounts_brands_delete');
Route::get('/api/discounts/brands/list', 'DiscountController@ajax_discounts_brands_listall')->name('ajax_discounts_brands_listall');
Route::get('/api/discounts/brands/add', 'DiscountController@ajax_discounts_brands_add')->name('ajax_discounts_brands_add');
Route::get('/api/discounts/brands/not', 'DiscountController@ajax_discounts_brands_not')->name('ajax_discounts_brands_not');

Route::get('/admin/marketing/discounts.html', 'DiscountController@discount_index')->name('discount_index');
Route::get('/admin/marketing/discounts/create.html', 'DiscountController@discount_create')->name('discount_create');
Route::get('/admin/marketing/discounts/{id}/edit.html', 'DiscountController@discount_edit')->name('discount_edit');

Route::get('/api/discounts/listall', 'DiscountController@ajax_discounts_list_all')->name('ajax_discounts_list_all');
Route::get('/api/discounts/get', 'DiscountController@ajax_discounts_get')->name('ajax_discounts_get');
Route::post('/api/discounts/save', 'DiscountController@ajax_discounts_save')->name('ajax_discounts_save');
Route::get('/api/discounts/delete', 'DiscountController@ajax_discounts_delete')->name('ajax_discounts_delete');
Route::get('/api/discounts', 'DiscountController@purchase_discounts_index')->name('purchase_discounts_index');

/* MODULE USERS */

Route::get('/api/users/brands/delete', 'UserController@ajax_user_brands_remove')->name('ajax_user_brands_remove');
Route::get('/api/users/brands/add', 'UserController@ajax_user_brands_add')->name('ajax_user_brands_add');
Route::get('/api/users/brands', 'UserController@ajax_user_brands')->name('ajax_user_brands');
Route::get('/api/users/categories/delete', 'UserController@ajax_user_categories_remove')->name('ajax_user_categories_remove');
Route::get('/api/users/categories/add', 'UserController@ajax_user_categories_add')->name('ajax_user_categories_add');
Route::get('/api/users/categories', 'UserController@ajax_user_categories')->name('ajax_user_categories');
Route::get('/api/users/getfavorites', 'HomeController@ajax_user_get_favorite')->name('ajax_user_get_favorite');
Route::get('/ajax/users/getone', 'UserController@ajax_users_getone')->name('ajax_users_getone');
Route::get('/ajax/users/listall', 'UserController@ajax_users_list_all')->name('ajax_users_list_all');
Route::get('/ajax/orders/change_status', 'OrderController@ajax_order_status_change')->name('ajax_order_status_change');

Route::get('/ajax/orders/getlog', 'OrderController@ajax_order_status_log')->name('ajax_order_status_log');

Route::get('admin/purchases/orders/status/{id}.html', 'OrderController@orders_index_by_status')->name('orders_index_by_status');
Route::get('/ajax/orders/status/listall', 'OrderController@ajax_orders_index_by_status')->name('ajax_orders_index_by_status');

/* MODULE BANNER */
Route::get('/api/banners/listall', 'BannerController@ajax_banners_list_all')->name('ajax_banners_list_all');
Route::get('/api/banners/get', 'BannerController@ajax_banners_get')->name('ajax_banners_get');
Route::post('/api/banners/save', 'BannerController@ajax_banners_save')->name('ajax_banners_save');
Route::get('/api/banners/delete', 'BannerController@ajax_banners_delete')->name('ajax_banners_delete');
Route::get('/api/banners', 'BannerController@purchase_banners_index')->name('purchase_banners_index');
Route::post('/api/banners/upload', 'BannerController@ajax_upload_banner')->name('ajax_upload_banner');

/* MODULE PURCHASE ORDER STATUSES */
Route::get('/api/orders/statuses/listall', 'PurchaseStatusController@ajax_order_status_list_all')->name('ajax_order_status_list_all');
Route::get('/api/orders/statuses/get', 'PurchaseStatusController@ajax_order_status_get')->name('ajax_order_status_get');
Route::post('/api/orders/statuses/save', 'PurchaseStatusController@ajax_order_status_save')->name('ajax_order_status_save');
Route::get('/api/orders/statuses/delete', 'PurchaseStatusController@ajax_order_status_delete')->name('ajax_order_status_delete');
Route::get('/api/orders/statuses', 'PurchaseStatusController@purchase_order_statuses_index')->name('purchase_order_statuses_index');

/* MODULE CATEGORIES*/
Route::get('/api/categories/listall', 'CategoryController@ajax_categories_list_all')->name('ajax_categories_list_all');
Route::get('/api/categories/get', 'CategoryController@ajax_categories_get')->name('ajax_categoriesbrands_get');
Route::post('/api/categories/save', 'CategoryController@ajax_categories_save')->name('ajax_categories_save');
Route::get('/api/categories/delete', 'CategoryController@ajax_categories_delete')->name('ajax_categories_delete');

/* MODULE BRANDS */
Route::get('/api/brands/listall', 'BrandController@ajax_brands_list_all')->name('ajax_brands_list_all');
Route::get('/api/brands/get', 'BrandController@ajax_brands_get')->name('ajax_brands_get');
Route::post('/api/brands/save', 'BrandController@ajax_brands_save')->name('ajax_brands_save');
Route::get('/api/brands/delete', 'BrandController@ajax_brands_delete')->name('ajax_brands_delete');

/* MODULE SUPPLIERS */

Route::get('/api/suppliers/products/get', 'SupplierController@ajax_suppliers_get_products')->name('ajax_suppliers_get_products');
Route::get('/api/suppliers/products/add', 'SupplierController@ajax_suppliers_add_products')->name('ajax_suppliers_add_products');
Route::get('/api/suppliers/products/delete', 'SupplierController@ajax_suppliers_delete_products')->name('ajax_suppliers_delete_products');

Route::get('/api/suppliers/listall', 'SupplierController@ajax_suppliers_list_all')->name('ajax_suppliers_list_all');
Route::get('/api/suppliers/get', 'SupplierController@ajax_suppliers_get')->name('ajax_suppliers_get');
Route::post('/api/suppliers/save', 'SupplierController@ajax_suppliers_save')->name('ajax_suppliers_save');
Route::get('/api/suppliers/delete', 'SupplierController@ajax_suppliers_delete')->name('ajax_suppliers_delete');

/* MODULE CONTACTS */
Route::post('/api/contacts/response', 'ContactController@ajax_response_contact')->name('ajax_response_contact');
Route::get('/api/contact/delete', 'ContactController@ajax_delete_contact')->name('ajax_delete_contact');
Route::get('/api/contact/listall', 'ContactController@ajax_list_all')->name('ajax_list_all');
Route::post('/api/contact/save', 'NewsletterController@ajax_save_contact')->name('ajax_save_contact');

/* MODULE MAILLING */
Route::get('/api/mailling/mails/get',  'NewsletterController@ajax_get_mail')->name('ajax_get_mail');
Route::get('/api/mailling/mails/brands', 'NewsletterController@ajax_get_all_brands')->name('ajax_get_all_brands');
Route::post('/api/mailling/mails/save', 'NewsletterController@ajax_save_mail')->name('ajax_save_mail');
Route::get('/api/mailling/mails/send', 'NewsletterController@ajax_send_mail')->name('ajax_send_mail');
Route::get('/api/mailling/mails/list', 'NewsletterController@ajax_list_all_mails')->name('ajax_list_all_mails');
Route::get('/api/mailling/mails/delete', 'NewsletterController@ajax_delete_contact')->name('ajax_delete_contact');

Route::get('/api/order/contact/getall', 'OrderController@ajax_getall_contact_order')->name('ajax_getall_contact_order');
Route::get('/api/account/order/removeproduct', 'AccountController@ajax_remove_product_from_order')->name('ajax_remove_product_from_order');
Route::post('/api/order/contact/send', 'OrderController@ajax_save_contact_order')->name('ajax_save_contact_order');
Route::post('/api/order/note/save', 'OrderController@ajax_save_note')->name('ajax_save_note');
Route::post('/api/mail/marketing', 'HomeController@send_mail_marketing')->name('send_mail_marketing');
Route::get('/api/products/is_on_wish_list', 'ProductController@is_on_wish_list')->name('is_on_wish_list');
Route::get('/api/products/remove_wish_list', 'ProductController@remove_wish_list')->name('remove_wish_list');
Route::get('/api/products/add_wish_list', 'ProductController@add_wish_list')->name('add_wish_list');
Route::get('/ajax/accounts/user_by_id', 'AccountController@ajax_get_user_by_id')->name('ajax_get_user_by_id');
Route::get('/ajax/accounts/orders/remake', 'AccountController@ajax_remake_orders')->name('ajax_remake_orders');
Route::get('/ajax/accounts/orders/disable', 'AccountController@ajax_disable_orders')->name('ajax_disable_orders');
Route::get('/ajax/countries/getall', 'AccountController@ajax_get_countries')->name('ajax_get_countries');
Route::post('/api/user/save', 'AccountController@ajax_save_user')->name('ajax_save_user');
Route::post('/ajax/users/save','UserController@ajax_users_save')->name('ajax_users_save');

Route::get("/ajax/orders/status", 'OrderController@ajax_statuses_list_all')->name('ajax_statuses_list_all');
Route::post('/api/login/recovery/complete', 'LoginContoller@ajax_recover_complete_index')->name('ajax_recover_complete_index');
Route::post('/api/login/recovery' , 'LoginContoller@ajax_recover_index')->name('ajax_recover_index');
Route::get('/ajax/country/getstates', 'RegisterController@ajax_get_state_by_country')->name('ajax_get_state_by_country');
Route::get('/ajax/orders/listall', 'OrderController@ajax_orders_list_all')->name('ajax_orders_list_all');
Route::post('/api/user/register', 'RegisterController@ajax_save_user')->name('ajax_save_user');
Route::get('register.html', 'RegisterController@register_index')->name('register_index');
Route::get('/ajax/accounts/orders', 'AccountController@ajax_account_orders')->name('ajax_account_orders');
Route::get('/ajax/purchase/order/save', 'CheckoutContoller@ajax_save_purchase')->name('ajax_save_purchase');
Route::get('/api/products/pictures/delete', 'ProductController@ajax_delete_picture')->name('ajax_delete_picture');
Route::get('/api/products/pictures/getall', 'ProductController@ajax_pictures_getall')->name('ajax_pictures_getall');
Route::get('/api/products/pictures/remove', 'ProductController@ajax_remove_file')->name('ajax_remove_file');
Route::post('/api/products/upload', 'ProductController@ajax_upload_file')->name('ajax_upload_file');
Route::get('/api/products/disable', 'ProductController@ajax_disable_product')->name('ajax_disable_product');
Route::post('/api/products/save', 'ProductController@ajax_save_product')->name('ajax_save_product');
Route::get('/api/products/types', 'ProductController@ajax_get_product_types')->name('ajax_get_product_types');
Route::get('/api/products/categories', 'ProductController@ajax_get_product_categories')->name('ajax_get_product_categories');
Route::get('/api/products/get', 'ProductController@ajax_products_list_one')->name('ajax_products_list_one');
Route::get('/api/products/listall', 'ProductController@ajax_products_list_all')->name('ajax_products_list_all');
Route::get('/api/products/add', 'ProductController@ajax_add_product')->name('ajax_add_product');
Route::get('/api/products/shopping/list','CheckoutContoller@ajax_get_shopping_cart')->name('ajax_get_shopping_cart');
Route::get('/api/products/shopping/remove','CheckoutContoller@ajax_remove_product_shopping_cart')->name('ajax_remove_product_shopping_cart');
Route::post('/api/products/shopping/save','CheckoutContoller@ajax_save_shopping_cart')->name('ajax_save_shopping_cart');
Route::get('/logout', 'LoginContoller@auth_get_logout')->name('auth_get_logout');
Route::post('/api/login', 'LoginContoller@ajax_post_login')->name('ajax_post_login');
Route::get('/api/login/token', 'LoginContoller@ajax_login_via_token')->name('ajax_login_via_token');

