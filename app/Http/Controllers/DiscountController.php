<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use DateTime;

class DiscountController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function discount_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('discount.index', ['user' => $user, 'controller' => 'DiscountController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_discounts_get(Request $request)
    {
        $id = $request->input("id");
        
        $discount = collect(DB::SELECT("SELECT d.by_percentage, by_client, d.by_period, d.by_brand, d.by_category, d.all_brands, d.all_categories, d.name, d.percentage, DATE_FORMAT(d.start_date, '%m/%d/%Y') as start_date, DATE_FORMAT(d.end_date, '%m/%d/%Y') as end_date FROM discounts d WHERE d.id=?", [$id]))->first();
        
        $brands = collect(DB::SELECT("SELECT b.* FROM product_brands b WHERE b.id IN (SELECT db.brand_id FROM discount_brands db WHERE db.discount_id=?)", [$id]));
        $categories = collect(DB::SELECT("SELECT pc.* FROM product_categories pc WHERE pc.id IN (SELECT category_id FROM discount_categories dc WHERE dc.discount_id=?)", [$id]));
        $clients = collect(DB::SELECT("SELECT u.* FROM users u WHERE u.ic_admin = 0 AND u.id IN (SELECT client_id FROM discount_clients dc WHERE dc.discount_id=?)", [$id]));

        return response()->json(array('discount' => $discount, 'brands' => $brands, 'clients' => $clients, 'categories' => $categories));
    }

    public function ajax_discounts_brands_listall(Request $request)
    {
        $id = $request->input("id");
        $brands = collect(DB::SELECT("SELECT b.* FROM product_brands b WHERE b.id IN (SELECT db.brand_id FROM discount_brands db WHERE db.discount_id=?)", [$id]));
        return response()->json($brands);
    }

    public function ajax_discounts_categories_delete(Request $request)
    {
        $id = $request->input('id');
        $category_id = $request->input('category_id');
        DB::TABLE('discount_categories')->where('category_id', $category_id)->where('discount_id', $id)->delete();
        return response()->json(array('created' => true));
    }

    public function ajax_discounts_clients_delete(Request $request)
    {
        $id = $request->input('id');
        $client_id = $request->input('client_id');
        DB::TABLE('discount_clients')->where('client_id', $client_id)->where('discount_id', $id)->delete();
        return response()->json(array('created' => true));
    }

    public function ajax_discounts_brands_delete(Request $request)
    {
        $id = $request->input('id');
        $brand_id = $request->input('brand_id');
        DB::TABLE('discount_brands')->where('brand_id', $brand_id)->where('discount_id', $id)->delete();
        return response()->json(array('created' => true));
    }

    public function ajax_discounts_clients_list(Request $request)
    {
        $id = $request->input("id");
        $clients = collect(DB::SELECT("SELECT u.* FROM users u WHERE u.ic_admin = 0 AND u.id IN (SELECT client_id FROM discount_clients dc WHERE dc.discount_id=?)", [$id]));
        return response()->json($clients);
    }

    public function ajax_discounts_categories_list(Request $request)
    {
        $id = $request->input("id");
        $categories = collect(DB::SELECT("SELECT pc.* FROM product_categories pc WHERE pc.id IN (SELECT category_id FROM discount_categories dc WHERE dc.discount_id=?)", [$id]));
        return response()->json($categories);
    }

    public function ajax_discounts_categories_add(Request $request)
    {
        $id = $request->input("id");
        $category_id = $request->input("category_id");
        $user_id = Auth::user()->id;

        $discount_category_id = DB::table("discount_categories")->insertGetId([
            'category_id' => $category_id, 'discount_id' => $id, 'user_id' => $user_id
        ]);

        return response()->json(array('created' => true, 'id' => $discount_category_id));
    }

    public function ajax_discounts_clients_add(Request $request)
    {
        $id = $request->input("id");
        $client_id = $request->input("client_id");
        $user_id = Auth::user()->id;

        $discount_clients_id = DB::table("discount_clients")->insertGetId([
            'client_id' => $client_id, 'discount_id' => $id, 'user_id' => $user_id
        ]);

        return response()->json(array('created' => true, 'id' => $discount_clients_id));
    }

    public function ajax_discounts_brands_add(Request $request)
    {
        $id = $request->input("id");
        $brand_id = $request->input("brand_id");
        $user_id = Auth::user()->id;

        $discount_brands_id = DB::table("discount_brands")->insertGetId([
            'brand_id' => $brand_id, 'discount_id' => $id, 'user_id' => $user_id
        ]);

        return response()->json(array('created' => true, 'id' => $discount_brands_id));
    }

    public function ajax_discounts_categories_not(Request $request)
    {
        $id = $request->input("id");
        $categories = collect(DB::SELECT("SELECT pc.* FROM product_categories pc WHERE pc.id NOT IN (SELECT category_id FROM discount_categories dc WHERE dc.discount_id=?)", [$id]));
        return response()->json($categories);
    }

    public function ajax_discounts_clients_not(Request $request)
    {
        $id = $request->input("id");
        $clients = collect(DB::SELECT("SELECT u.* FROM users u WHERE u.ic_admin = 0 AND u.id NOT IN (SELECT client_id FROM discount_clients dc WHERE dc.discount_id=?)", [$id]));
        return response()->json($clients);
    }

    public function ajax_discounts_brands_not(Request $request)
    {
        $id = $request->input("id");
        $brands = collect(DB::SELECT("SELECT b.* FROM product_brands b WHERE b.id NOT IN (SELECT db.brand_id FROM discount_brands db WHERE db.discount_id=?) ORDER BY b.name ASC", [$id]));
        return response()->json($brands);
    }

    public function ajax_discounts_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM discounts d WHERE d.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $discounts = DB::SELECT("SELECT d.id, d.name, d.percentage, DATE_FORMAT(d.start_date, '%m/%d/%Y') as start_date, DATE_FORMAT(d.end_date, '%m/%d/%Y') as end_date  FROM discounts d ORDER BY d.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('discounts' => $discounts, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function discount_edit($id)
    {
        $user =  Auth::user();
        return view('discount.create', ['user' => $user, 'operation_create' => false, 'id' => $id, 'controller' => 'DiscountController']);
    }

    public function discount_create()
    {
        $user =  Auth::user();

        DB::table('discounts')->where('user_id', $user->id)->where('active', 0)->delete();
        $id = DB::table('discounts')->insertGetId(['active' => 0, 'user_id' => $user->id]);
        return view('discount.create', ['user' => $user, 'operation_create' => true, 'id' => $id, 'controller' => 'DiscountController']);
    }

    public function ajax_discounts_delete(Request $request)
    {
        $id = $request->input("id");
        DB::table('discounts')->where('id', $id)->delete();
        return response()->json(array('deleted' => true));
    }

    public function ajax_discounts_save(Request $request)
    {
        $by_percentage = $request->input("by_percentage", 0);
        $by_period = $request->input("by_period", 0);
        $by_brand = $request->input("by_brand", 0);
        $by_client = $request->input("by_client", 0);
        $by_category = $request->input("by_category", 0);

        $id = $request->input('id');
        
        $name = $request->input('name');
        $percentage = $request->input('percentage');
        $start_date = $request->input('start_date');
        $end_date = $request->input('end_date');
        
        if(strlen($start_date) > 0)
        {
            $start_date_format = DateTime::createFromFormat('m/d/Y', $start_date);
            $start_date = $start_date_format->format('Y-m-d');
        }

        if(strlen($end_date))
        {
            $end_date_format =  DateTime::createFromFormat('m/d/Y', $end_date);
            $end_date = $end_date_format->format('Y-m-d');
        }

        DB::table('discounts')->where('id', $id)->update([
            'by_percentage' => $by_percentage, 'by_period' => $by_period, 'by_brand' => $by_brand, 
            'by_client' => $by_client, 'by_category' => $by_category, 'name' => $name, 'percentage' => $percentage,
            'start_date' => $start_date, 'end_date' => $end_date, 'active' => 1
        ]);

        return response()->json(array('created' => true, 'id' => $id));
    }
}
