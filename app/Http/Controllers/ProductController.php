<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ajax_disable_product(Request $request)
    {
        $user = Auth::user();
        $id = $request->input("id");
        $created = false;

        if($user->ic_admin)
        {
            DB::table('products')->where("code", "=", $id)->update(
                ['active' => 0]
            );
            $created = true;
        }

        return response()->json(array('created' => $created, 'id' => $id));
    }

    public function product_detail($route)
    {
        $product = collect(DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p  WHERE p.active=1 AND (p.route=? OR p.code=?)", [$route, $route]))->first();
        
        if(!empty($product))
        {
        
            //$categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id) > 0 LIMIT 20");
            
            if(Auth::guest())
            {
                $categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id) > 0 LIMIT 20");
            }else{
                $user_test = Auth::user();

                if($user_test->self_register_user || $user_test->ic_admin)
                {
                    $categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id AND p.active=1) > 0 LIMIT 20");
                }else{
                    $categories = DB::SELECT("SELECT pb.id, pb.name, pb.route FROM user_has_product_brands  upb JOIN product_brands pb ON upb.product_brand_id=pb.id WHERE up.user_id=? ORDER BY pb.name ASC", [$user_test->id]);
                }            
            }
            
            $category = collect(DB::SELECT("SELECT * FROM product_brands WHERE id=?", [$product->brand_id]))->first();
            $images = DB::SELECT("SELECT * FROM product_images pi WHERE pi.product_id=?", [$product->code]);
            $types = DB::SELECT("SELECT * FROM product_types");

            $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p WHERE p.brand_id=? AND p.code != ? LIMIT 8", [$product->brand_id, $product->code]);
            
            $supplier = collect(DB::SELECT("SELECT * FROM suppliers s WHERE s.id=?", [$product->supplier_id]))->first();
            $user = Auth::user();

            if(!empty($user))
            {
                $items = collect(DB::SELECT("SELECT sum(sc.quantity) as total FROM shopping_cart sc WHERE sc.user_id=?", [$user->id]))->first();
            }

            return view('product.detail', [ 'page_title' => $product->item, 'page_description' => $product->description,'product' => $product, 'total_items' => !empty($items) ? $items->total : 0, 'categories' => $categories, 'category' => $category, 'images' => $images, 'types' => $types, 'supplier' => $supplier,'products' => $products, 'user' => Auth::user()]);
        }else{
            return view('error.error404');
        }
    }

    public function ajax_delete_picture(Request $request)
    {
        $id = $request->input('id');
        DB::table('product_images')->where('id', $id)->delete();
        return response()->json(array('deleted' => true, 'id' => $id));
    }

    public function remove_wish_list(Request $request)
    {
        $id = $request->input("id");
        $user_id = Auth::user()->id;

        DB::table('wish_list')->where('product_id','=', $id)->where('user_id','=', $user_id)->delete();
        $total = collect(DB::SELECT("SELECT count(*) as total FROM wish_list WHERE user_id=?", [ $user_id]))->first()->total;

        return response()->json(array('total_items' => $total));
    }

    public function is_on_wish_list(Request $request)
    {
        $id = $request->input("id");
        $user_id = Auth::user()->id;

        $on_wish = collect(DB::SELECT("SELECT count(*) as total FROM wish_list WHERE user_id=? AND product_id=?", [ $user_id, $id]))->first()->total;
        $total = collect(DB::SELECT("SELECT count(*) as total FROM wish_list WHERE user_id=?", [ $user_id]))->first()->total;

        return response()->json(array('on_list' => $on_wish > 0, 'total_items' => $total));
    }

    public function add_wish_list(Request $request)
    {
        $id = $request->input("id");
        $user_id = Auth::user()->id;

        $total = collect(DB::SELECT("SELECT count(*) as total FROM wish_list WHERE user_id=? AND product_id=?", [ $user_id, $id]))->first()->total;

        if($total < 1)
        {
            DB::table('wish_list')->insert([
                'user_id' => $user_id, 'product_id' => $id
            ]);
        }

        $total = collect(DB::SELECT("SELECT count(*) as total FROM wish_list WHERE user_id=?", [ $user_id]))->first()->total;

        return response()->json(array('total_items' => $total));
    }


    public function ajax_pictures_getall(Request $request)
    {
        $id = $request->input("id");
        $pictures = DB::SELECT("SELECT * FROM product_images WHERE product_id=?" , [$id]);
        return response()->json($pictures);
    }

    public function ajax_remove_file(Request $request)
    {
        $name = $request->input('name');
        //DB::table('product_images')->where('original_name', '=', $name)->where('user_id', '=', Auth::user()->id)->delete();
        $item = collect(DB::SELECT("SELECT id FROM product_images WHERE original_name=? AND user_id=? AND product_id IS NULL", [$name, Auth::user()->id]))->first();
        if(!empty($item))
        {
            DB::table('product_images')->where('id', $item->id);
        }
        return response()->json(array('deleted' => true, 'item' => $item));
    }

    public function ajax_upload_file(Request $request)
    {
        $nameFile = null;
        $upload = false;
        $destiny = "";
        $task_file_id = 0;
        $description = "";
        $product_image_id = 0;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
           
            try{
               $name = uniqid(date('HisYmd'));
               $extension = $request->file('file')->extension();
               $nameFile = "{$name}.{$extension}";
               $destiny = $request->file('file')->store('uploads'); 
               $upload = true; 
               $client_name = $request->file('file')->getClientOriginalName();

                $product_image_id = DB::table('product_images')->insertGetId(
                    ['name' => $name, 'original_name' => $client_name, 'location' => "app/".$destiny, 'extension' => $extension, 'user_id' => Auth::user()->id]
                );
            }catch(Exception $ex){
                $upload = false;
                $description = $ex->getMessage();
            }

        }

       return response()->json(array('uploaded' => $upload, 'product_image_id' => $product_image_id, 'storage' => "storage/app/".$destiny, 'file_name' => $nameFile, 'message' => $description));
    }

    public function product_admin_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('product.admin', ['user' => $user, 'controller' => 'ProductController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_get_product_types(Request $request)
    {
        $types = DB::SELECT("SELECT * FROM product_types");
        return response()->json($types);
    }

    public function ajax_save_product(Request $request)
    {
        $request->validate([
            'price' => 'required|min:1|max:255',
            'minimum_stock' => 'required|min:1|max:255',
            'barcode' => 'required|min:10|max:255',
            'qr_code' => 'required|min:5|max:255',
            'items_on_box' => 'required|min:1|max:255',
            'gross_price' => 'required|min:1|max:255',
            'minimum_stock' => 'required|min:1|max:255',
        ]);

        $description = $request->input('description');
        $gross_price = $request->input('gross_price');
        $item = $request->input('item');
        $price = $request->input('price');
        $product_type_id = $request->input('product_type_id');
        $brand_id = $request->input('brand_id');
        $items_on_box = $request->input('items_on_box');
        $cold_description = $request->input('cold_description');
        $qrcode = $request->input('qrcode');
        $barcode = $request->input('barcode');
        $minimum_stock = $request->input('minimum_stock');

        $supplier_id = 1;

        $operation = "none";

        if($request->has("code"))
        {
            $code = $request->input("code");
            DB::table('products')->where('code', $code)->update(
                ['brand_id' => $brand_id, 'cold_description' => $cold_description,'description' => $description, 
                'items_on_box' => $items_on_box, 'gross_price' => $gross_price, 'item' => $item, 'price' => $price,  'product_type_id' => $product_type_id, 
                'supplier_id' => $supplier_id, 'qrcode' => $qrcode, 'barcode' => $barcode, 'minimum_stock' => $minimum_stock ]
            );
            $operation = "update";
        }else{
            $code = DB::table('products')->insertGetId(
                ['brand_id' => $brand_id,'cold_description' => $cold_description,'description' => $description, 
                'items_on_box' => $items_on_box, 'gross_price' => $gross_price, 'item' => $item, 'price' => $price,  
                'product_type_id' => $product_type_id, 'supplier_id' => $supplier_id, 'qrcode' => $qrcode, 'barcode' => $barcode, 'minimum_stock' => $minimum_stock ]
            );            
            $operation = "create";
        }

        DB::table('product_images')->where('user_id', Auth::user()->id)->whereNull('product_id')->update(['product_id' => $code]);

        return response()->json(array('created' => true, 'operation' => $operation, 'code' => $code));
    }

    public function ajax_get_product_categories(Request $request)
    {
        $categories = DB::SELECT("SELECT * FROM product_categories ORDER BY name ASC");
        return response()->json($categories);
    }

    public function ajax_products_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page  * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM products p WHERE p.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $products = DB::SELECT("SELECT p.*, pb.name as category_name_str, pt.name as product_type_name_str FROM products p 
        LEFT JOIN product_brands pb ON pb.id=p.brand_id LEFT JOIN product_types pt ON pt.id=p.product_type_id 
        WHERE p.active=1 ORDER BY p.item ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('products' => $products, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_products_list_one(Request $request)
    {
        $id = $request->input("id");
        $product = collect(DB::SELECT("SELECT p.* FROM products p WHERE p.code=?", [$id]))->first();
        return response()->json($product);
    }

    public function ajax_products_types(Request $request)
    {
        $products = DB::SELECT("SELECT * product_types pt");
        return response()->json($products);
    }

    public function ajax_add_product(Request $request)
    {
        $product_id = $request->input("id");
        $quantity = $request->input("quantity", 1);
        $user = Auth::user();

        $operation = '';
        $product = collect(DB::SELECT("SELECT * FROM shopping_cart sc WHERE sc.user_id=? AND product_id=?", [$user->id, $product_id]))->first();
        if(empty($product))
        {
            $operation = 'create';
            $id = DB::table('shopping_cart')->insertGetId(
                ['user_id' => $user->id, 'product_id' => $product_id, 'quantity' => $quantity]
            );

        }else
        {
            $operation = 'update';
            $quantity = $quantity + $product->quantity;
            DB::table('shopping_cart')->where('user_id', $user->id)->where('product_id', $product_id)->update(
                ['quantity' => $quantity]
            );
        }

        $items = collect(DB::SELECT("SELECT sum(sc.quantity) as total FROM shopping_cart sc WHERE sc.user_id=?", [$user->id]))->first();

        return response()->json(array('created' => true, 'operation' => $operation, 'total_items' => $items->total));
    }
}
