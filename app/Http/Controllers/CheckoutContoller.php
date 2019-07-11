<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class CheckoutContoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function checkout_index()
    {
        $user = Auth::user();
        //$products = DB::SELECT("SELECT p.*, sc.user_id, sc.quantity, (sc.quantity * p.price) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?", [$user->id]);
        //$total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;
        return view('checkout.index', ['user' => $user, 'controller' => 'CheckoutController']);
    }

    public function ajax_save_purchase(Request $request)
    {
        $user = Auth::user();

        $items = DB::SELECT("SELECT * FROM shopping_cart WHERE user_id=?", [$user->id]);
        $total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;

        $total_purchases_on_this_month = collect(DB::SELECT("SELECT SUM(pohp.quantity * pohp.price) as total FROM purchase_order_has_products pohp JOIN purchase_order po ON po.id=pohp.purchase_order_id WHERE po.user_id=?", [$user->id]))->first()->total;

        if(($total_purchases_on_this_month + $total) < $user->purchase_limit || !$user->has_purchase_limit)
        {
            $purchase_order_id = DB::table('purchase_order')->insertGetId(
                ['user_id' => $user->id, 'total' => $total]
            );

            foreach($items as $item)
            {
                $price = 0;
                $product_temp = collect(DB::SELECT("SELECT * FROM products p WHERE p.code=?", [ $item->product_id ]))->first();

                if(!empty($product_temp))
                {
                    $price = $product_temp->price;
                }

                DB::table('purchase_order_has_products')->insertGetId(
                    ['product_id' => $item->product_id, 'purchase_order_id' => $purchase_order_id, 'quantity' => $item->quantity, 'price' => $price ]
                );
            }

            DB::table('shopping_cart')->where('user_id', '=', $user->id)->delete();

            $to_name = $user->name;
            $to_email = $user->email;

            $data = array('email' => $to_email, 'order_id' => $purchase_order_id, 'url' => 'https://wholesalecompany.ca/account/orders/'.$purchase_order_id, 'user_name' => $user->name);

            \Mail::send('emails.order', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Order status');
                $message->from('no-reply@blascke.com','WholeSales Canada');
            });

            $data = array('created' => true, 'total' => $total, 'id' => $purchase_order_id);
        }else{
            $data = array('created' => false, 'error' => 'You reach your limit');
        }

        return response()->json($data);        

    }

    public function ajax_get_shopping_cart()
    {
        $user = Auth::user();
        $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image, sc.user_id, sc.quantity, (sc.quantity * p.price) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?", [$user->id]);
        $total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;

        return response()->json(array('products' => $products, 'total' => $total));
    }

    public function ajax_remove_product_shopping_cart(Request $request)
    {

        $id = $request->input("id");
        $user = Auth::user();

        DB::table('shopping_cart')->where('product_id', '=', $id)->where('user_id', '=', $user->id)->delete();

        $products = DB::SELECT("SELECT p.*, sc.user_id, sc.quantity, (sc.quantity * p.price) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?", [$user->id]);
        $total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;

        return response()->json(array('products' => $products, 'total' => $total));
    }

    public function ajax_save_shopping_cart(Request $request)
    {
        $user = Auth::user();
        $cart = $request->input('cart');
        
        foreach($cart as $item)
        {
            DB::table('shopping_cart')->where('user_id', $user->id)->where('product_id', $item['code'])->update(
                ['quantity' => $item['quantity']]
            );
        }

        $products = DB::SELECT("SELECT p.*, sc.user_id, sc.quantity, (sc.quantity * p.price) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?", [$user->id]);
        $total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;

        return response()->json(array('products' => $products, 'total' => $total));
    }

    public function finalize_checkout()
    {
        $user = Auth::user();
        $company = collect(DB::SELECT("SELECT c.* FROM companies c JOIN users u ON c.id=u.company_id WHERE u.id=?", [$user->id]))->first();
        $products = DB::SELECT("SELECT p.*, sc.user_id, sc.quantity, (sc.quantity * p.price) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?", [$user->id]);
        $total = collect(DB::SELECT("SELECT SUM(sub_price) as total FROM (SELECT p.price, sc.user_id, sc.quantity, (p.price * sc.quantity) as sub_price FROM shopping_cart sc JOIN products p ON p.code=sc.product_id WHERE user_id=?) as tbl ", [$user->id]))->first()->total;

        return view('checkout.final', ['products' => $products, 'total' => $total, 'user' => $user, 'company' => $company ]);
    }
}
