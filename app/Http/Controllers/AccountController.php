<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function account_index(Request $request)
    {
        $countries = DB::SELECT("SELECT * FROM countries");
        return view('account.index', ['user' => Auth::user(), 'countries' => $countries, 'controller' => 'AccountController']);
    }

    public function acount_index_order($id)
    {
        $user_id = Auth::user()->id;
        $order = collect(DB::SELECT("SELECT o.id, o.user_id, o.created_at, o.status_id, o.active, (SELECT SUM(po.price * po.quantity) FROM purchase_order_has_products po WHERE po.purchase_order_id=o.id) as total, DATE_FORMAT(o.created_at, '%m/%d/%Y') as order_date  FROM purchase_order o WHERE o.id=? and o.user_id=?", [$id, $user_id]))->first();
        if(!empty($order)){
        $products = DB::SELECT("SELECT p.code, po.quantity, po.price, p.item as name, (po.price * po.quantity) as subtotal FROM purchase_order_has_products po JOIN purchase_order o ON po.purchase_order_id=o.id 
        JOIN products p ON p.code=po.product_id   WHERE o.id=? and o.user_id=?", [$id, $user_id]);
        return view('account.view_order', ['user' => Auth::user(), 'controller' => 'AccountController', 'order' => $order, 'products' => $products]);
    }else
    {
        return redirect('/');
    }
    }

    public function ajax_remove_product_from_order(Request $request)
    {
        $order_id = $request->input("order_id");
        $product_id = $request->input("product_id");

        $order = collect(DB::table('purchase_order')->where('id', $order_id)->get())->first();

        $deleted = $order->status_id == 1;
        $text = "";

        $items_on_order = collect(DB::select("SELECT count(*) as total FROM purchase_order_has_products WHERE purchase_order_id=? AND product_id=?", [$order_id, $product_id]))->first()->total;
        
        if($items_on_order > 1)
        {
            if($order->status_id == 1)
            {
                DB::table("purchase_order_has_products")->where('purchase_order_id', $order_id)->where('product_id', $product_id)->delete();
                $text = "Product deleted sucessfully";
            }else{
                $text = "Processed orders can not be changed";    
                $deleted = false;
            }
        }else {
            $text = "You can not delete the last product on the order, delete the order instead";
            $deleted = false;
        }

        $data = array('deleted' => $deleted, 'text' => $text, 'order_id' => $order_id, 'product_id' => $product_id);
        return response()->json($data);
    }

    public function ajax_change_product_from_order(Request $request)
    {
        $order_id = $request->input("order_id");
        $product_id = $request->input("product_id");

    }

    public function ajax_get_countries(Request $request)
    {
        $countries = DB::SELECT("SELECT * FROM countries");
        return response()->json($countries);
    }

    public function ajax_save_user(Request $request)
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

        if($request->has("id"))
        {
            $user_id = $request->input("id");

            $user = collect(DB::SELECT("SELECT * FROM users u WHERE u.id=?", [$user_id]))->first();

            DB::table('users')->where('id', '=', $user_id)->update(
                ['name' => $name, 'email' => $email,  'phone' => $phone,
                'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code]
            );
        }else{
            $user_id = DB::table('users')->insertGetId(
                ['name' => $name, 'email' => $email, 'phone' => $phone,
                'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code]
            );
        }

        return response()->json(array('created' => true, 'id' => $user_id));
    }

    public function ajax_get_user_by_id(Request $request)
    {
        $id = $request->input("id");
        $user = collect(DB::SELECT("SELECT * FROM users WHERE id=?", [$id]))->first();
        return response()->json($user);
    }

    public function ajax_account_orders(Request $request)
    {
        $user_id = Auth::user()->id;
        $orders = DB::SELECT("SELECT po.*, ps.name as status_name, DATE_FORMAT(po.created_at, '%M %d %Y') as date FROM purchase_order po 
        JOIN purchase_status ps ON ps.id=po.status_id WHERE user_id=? AND po.active=1 ORDER BY po.id DESC", [ $user_id ]);
        return response()->json($orders);
    }

    public function ajax_remake_orders(Request $request)
    {
        $id = $request->input("id");
        $user = Auth::user();
        $order = collect(DB::SELECT("SELECT * FROM purchase_order po WHERE po.id=?", [$id]))->first();

        $total = collect(DB::SELECT("SELECT sum(p.price * po.quantity) as total FROM purchase_order_has_products po JOIN products p ON p.code=po.product_id WHERE po.purchase_order_id=?", [$id]))->first()->total;
        
        $new_purchase_order_id = DB::table("purchase_order")->insertGetId(
            ['user_id' => $user->id, 'total' => $total, 'active' => 1]
        );

       $products = DB::SELECT("SELECT  po.quantity, p.*  FROM purchase_order_has_products po  JOIN products p ON p.code=po.product_id WHERE po.purchase_order_id=?", [$id]);

       foreach($products as $product)
       {
            DB::table("purchase_order_has_products")->insertGetId(
                ['product_id' => $product->code, 'purchase_order_id' => $new_purchase_order_id, 'quantity' => $product->quantity, 'price' => $product->price]
            );
       }

       $data = array('email' => $user->email, 'order_id' => $new_purchase_order_id, 'url' => 'http://wholesalecompany.ca//account/orders/'.$new_purchase_order_id, 'user_name' => $user->name);
       $to_email = $user->email;
       $to_name = $user->name;

        \Mail::send('emails.order', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Order status');
            $message->from('no-reply@blascke.com','WholeSales Canada');
        });


       return response()->json(array('created' => true));
    }

    public function ajax_disable_orders(Request $request)
    {
        $id = $request->input("id");
        DB::TABLE('purchase_order')->where('id', '=', $id)->update(['active' => 0]);
        return response()->json(array('created' => true));
    }
}
