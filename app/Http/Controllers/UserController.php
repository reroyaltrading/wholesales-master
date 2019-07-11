<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function users_index()
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('directory.users', ['user' => $user, 'controller' => 'UserController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_users_list_all(Request $request)
    {
        if(Auth::user()->ic_admin)
        {
            
            $page = $request->input('page', 1);
            $items_per_page = $request->input('items_per_page', 25);
            $start_from = $page * $items_per_page;

            $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM users u"))->first()->total;
            $total_pages = ceil($total / $items_per_page);       

            $users = DB::SELECT("SELECT u.* FROM users u ORDER BY u.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

            $data = array('users' => $users, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

            return response()->json($data);

        }else{
            return response()->json(array());
        }
    }

    public function ajax_user_brands(Request $request)
    {
        $id = $request->input("id");
        $categories_have = DB::SELECT("SELECT pb.id, pb.name FROM user_has_product_brands  up JOIN product_brands pb ON up.product_brand_id=pb.id WHERE up.user_id=? ORDER BY pb.name ASC", [$id]);
        $categories_not = DB::SELECT("SELECT * FROM product_brands pb WHERE pb.id NOT IN (SELECT upb.product_brand_id FROM user_has_product_brands upb WHERE upb.user_id=?) ORDER BY pb.name ASC", [$id]);

        $data = array('brands_have' => $categories_have, 'brands_not' => $categories_not);
        return response()->json($data, 200);
    }

    public function ajax_user_brands_remove(Request $request)
    {
        $brand_id  = $request->input('brand_id');
        $user_id  = $request->input('user_id');
        DB::table('user_has_product_brands')->where('product_brand_id', $brand_id)->where('user_id', $user_id)->delete();
        return response()->json(array('deleted' => true, 'id' => $user_id));
    }

    public function ajax_user_brands_add(Request $request)
    {
        $brand_id  = $request->input('brand_id');
        $user_id  = $request->input('user_id');
        DB::table('user_has_product_brands')->insertGetId(['product_brand_id' => $brand_id, 'user_id' => $user_id]);
        return response()->json(array('created' => true, 'id' => $user_id));
    }

    public function ajax_user_categories_remove(Request $request)
    {
        $category_id  = $request->input('category_id');
        $user_id  = $request->input('user_id');
        DB::table('user_has_product_categories')->where('product_category_id', $category_id)->where('user_id', $user_id)->delete();
        return response()->json(array('deleted' => true, 'id' => $user_id));
    }

    public function ajax_user_categories_add(Request $request)
    {
        $category_id  = $request->input('category_id');
        $user_id  = $request->input('user_id');
        DB::table('user_has_product_categories')->insertGetId(['product_category_id' => $category_id, 'user_id' => $user_id]);
        return response()->json(array('created' => true, 'id' => $user_id));
    }

    public function ajax_users_getone(Request $request)
    {
        $id = $request->input("id");
        $user = collect(DB::SELECT("SELECT * FROM users u WHERE u.id=?", [$id]))->first();
        return response()->json($user);
    }

    public function ajax_user_categories(Request $request)
    {
        $id = $request->input("id");
        $categories_have = DB::SELECT("SELECT pc.id, pc.name FROM user_has_product_categories  up JOIN product_categories pc ON up.product_category_id=pc.id WHERE up.user_id=? ORDER BY pc.name ASC", [$id]);
        $categories_not = DB::SELECT("SELECT * FROM product_categories pc WHERE pc.id NOT IN (SELECT up.product_category_id FROM user_has_product_categories up WHERE up.user_id=?) ORDER BY pc.name ASC", [$id]);

        $data = array('categories_have' => $categories_have, 'categories_not' => $categories_not);
        return response()->json($data, 200);
    }

    public function ajax_users_save(Request $request)
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $phone = $request->input("phone");
        $repeat = $request->input("repeat");
        $address = $request->input("address");
        $city = $request->input("city");
        $country_id = $request->input("country_id");
        $state_id = $request->input("state_id");
        $zip_code = $request->input("zip_code");
        $ic_admin = $request->input("ic_admin", 0);
        $new_password = $request->input("new_password");

        $has_purchase_limit = $request->input("has_purchase_limit", 0);
        $purchase_limit = $request->input("purchase_limit");


        if($request->has("id"))
        {
            $user_id = $request->input("id");
            $user = collect(DB::SELECT("SELECT * FROM users u WHERE u.id=?", [$user_id]))->first();

            if(strlen($new_password) > 0)
            {
                DB::table('users')->where('id', '=', $user_id)->update(
                    ['name' => $name, 'purchase_limit' => $purchase_limit, 'has_purchase_limit' => $has_purchase_limit, 'email' => $email,  'phone' => $phone, 'ic_admin' => $ic_admin, 'password' => md5($new_password),
                    'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code]
                );
            }else
            {
                DB::table('users')->where('id', '=', $user_id)->update(
                    ['name' => $name, 'purchase_limit' => $purchase_limit, 'has_purchase_limit' => $has_purchase_limit, 'email' => $email,  'phone' => $phone, 'ic_admin' => $ic_admin,
                    'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code]
                );
            }
            
        }else{
            $user_id = DB::table('users')->insertGetId(
                ['name' => $name, 'purchase_limit' => $purchase_limit, 'has_purchase_limit' => $has_purchase_limit, 'email' => $email, 'phone' => $phone, 'ic_admin' => $ic_admin, 'password' => md5($new_password),
                'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code]
            );

            $to_name = $name;
            $to_email = $email;

            $data = array('email' => $to_email, 'user_id' => $user_id, 'url' => 'https://wholesalecompany.ca/account/verify/'.md5($user_id), 'user_name' => $name);

            \Mail::send('emails.welcome', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Welcome to WholeSales');
                $message->from('no-reply@blascke.com','WholeSales Canada');
            });
        }

        return response()->json(array('created' => true, 'id' => $user_id));
    }
}
