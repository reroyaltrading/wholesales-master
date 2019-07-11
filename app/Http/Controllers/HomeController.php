<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class HomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function ajax_user_get_favorite(Request $request)
    {
        $id = $request->input("id");
        $favorites = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM wish_list wl JOIN products p ON p.code=wl.product_id WHERE wl.user_id=?", [$id]);
        return response()->json($favorites);
    }

    public function unsubscribe_email($hash)
    {
        $subscription = DB::SELECT("SELECT * FROM mail_subscription WHERE subscription_hash=?", [$hash]);
        if(count($subscription) > 0)
        {
            DB::table('mail_subscription')->where('subscription_hash', '=', $hash)->delete();
        }

        return view('home.unsubscribe', ['removed' => count($subscription) > 0, 'subs' => count($subscription) > 0 ? collect($subscription)->first() : '']);
    }

    public function send_mail_marketing(Request $request)
    {

        $email = $request->input('email');

        $to_name = 'Client';
        $to_email = $email;

        $subscription_hash = md5($email.date('Y').time());

        $subs_id =  DB::table('mail_subscription')->insertGetId(['email' => $email, 'subscription_hash' => $subscription_hash ]);

        $data = array('email' => $to_email, 'subs_id' => $subs_id, 'unssubscription_url' => 'https://wholesalecompany.ca/mailling/unsubscribe/'.$subscription_hash,'url' => 'https://wholesalecompany.ca/index.html', 'user_name' => $to_name);

        \Mail::send('emails.newsletter', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('WholeSales Newsletter Subscription');
            $message->from('no-reply@blascke.com','WholeSales Canada');
        });

        return response()->json(array('created' => true, 'email' => $email));
    }

    public function home_index(Request $request)
    {
        $extra = "";
        $term = "";

        $has_search = false;

        $price_min = $request->input("price_min", 0);
        $price_max = $request->input("price_max", 0);

        if(strlen($price_min) <= 0){ $price_min = 0; }
        if(strlen($price_max) <= 0){ $price_max = 0; }

        $term = $request->input('term');

        if($request->has('term') || $request->has('price_min') ||  $request->has('price_max'))
        {
            if(strlen($term) > 0 || $price_min > 0 || $price_max > 0)
            {
                $extra .= " WHERE ";
                $has_search = true;
            }
        }

        if(strlen($term) > 0)
        {
                $extra .= " (type LIKE '%$term%'";
                $extra .= " OR item LIKE '%$term%'";
                $extra .= " OR description LIKE '%$term%') ";
        }

        if($request->has('term') && $request->has('price_min') &&  $request->has('price_max'))
        {
            $extra .= " AND ";
        }


        if($price_min >= 0 && $price_max > 0)
        {
            $extra .= (' (p.price >= '.(strlen($price_min) > 0 ? $price_min : '0').' AND price <='.(strlen($price_max) > 0 ? $price_max : '6').' )');
        }else if($price_min > 0 && $price_max == 0)
        {
            $extra.=('p.price >= '.$price_min);
        }else if($price_min === 0 && $price_max > 0)
        {
            $extra.=('p.price <= '.$price_max);
        }

        $itens_per_page = $request->input("itens_per_page", 24);
        $page = $request->input("page", 1);
        $page = $page - 1;
        $start = $page * $itens_per_page;
        $end =  $itens_per_page; //($page * $itens_per_page) + $itens_per_page;

        $user_test = Auth::guest() ? null : Auth::user();
        $show_all_categories = Auth::guest() ? true : $user_test->self_register_user || $user_test->ic_admin;

        if($page == 0 && $show_all_categories)
        {
            $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p JOIN(SELECT code  FROM  products WHERE  RAND() < (SELECT ((4 / COUNT(*)) * 10)  FROM products) ORDER BY RAND() LIMIT 24) AS z ON z.code= p.code ".$extra);
        }else if($page > 0 && $show_all_categories){
            $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p " . $extra. " LIMIT $start, $end;");
        }else if(!$show_all_categories)        
        {
            $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p " . (strlen($extra) > 0 ? $extra : ' WHERE ')." p.brand_id IN (SELECT product_brand_id FROM user_has_product_brands upb WHERE upb.user_id=?) LIMIT $start, $end;", [$user_test->id]);
        }
        
        if($show_all_categories)
        {
            $total_products = collect(DB::SELECT("SELECT count(*) as total FROM products p " .  $extra))->first()->total;
        }else{
            $total_products = collect(DB::SELECT("SELECT count(*) as total FROM products p " . (strlen($extra) > 0 ? $extra : ' WHERE '). " p.brand_id IN (SELECT product_brand_id FROM user_has_product_brands upb WHERE upb.user_id=".$user_test->id.") "))->first()->total;
        }
        $total_pages = ceil($total_products / $itens_per_page);

        $temp_page = $page + 1;
        $max_page = ($temp_page < ($total_pages - 3)) ? $temp_page + 3 : $total_pages;
        $min_page = ($temp_page - 3 >= 1) ? ($temp_page - 3) : $temp_page;

        //$products = DB::SELECT("SELECT * FROM products p " . $extra. " LIMIT 24");

        if($show_all_categories)
        {
            $categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id AND p.active=1) > 0 LIMIT 20");
        }else{
            $categories = DB::SELECT("SELECT pb.id, pb.name, pb.route FROM user_has_product_brands upb JOIN product_brands pb ON upb.product_brand_id=pb.id WHERE upb.user_id=?  ORDER BY pc.name ASC", [$user_test->id]);
        }

        
        $types = DB::SELECT("SELECT * FROM product_types");
        $user = Auth::user();

        if(!empty($user))
        {
            $items = collect(DB::SELECT("SELECT sum(sc.quantity) as total FROM shopping_cart sc WHERE sc.user_id=?", [$user->id]))->first();
        }

        $banners = DB::SELECT("SELECT b.url_link, bi.location FROM banner_images bi JOIN banners b ON b.id=bi.banner_id WHERE now() BETWEEN b.start_date AND b.end_date");

        return view('welcome', [ 'controller' => 'HomeController', 'page_title' => $has_search ? 'Search result' : 'Home', 'has_search' => $has_search, 'total_products' => $total_products,  'price_min' => $price_min, 
        'price_max' => $price_max ,'min_page' => $min_page, 'max_page' => $max_page, 'term' => $term,'total_pages' => $total_pages,
        'page' => ($page + 1), 'itens_per_page' => $itens_per_page, 'start' => $start, 'end' => $end, 'products' => $products, 
        'categories' => $categories, 'types' => $types, 'user' => Auth::user(), 'total_items' => !empty($items) ? $items->total : 0, 'banners' => $banners ]);
    }

    public function home_category_index($id, Request $request)
    {
        $extra = "";
        $term = "";

        $has_search = false;

        $price_min = $request->input("price_min", 0);
        $price_max = $request->input("price_max", 0);

        if(strlen($price_min) <= 0){ $price_min = 0; }
        if(strlen($price_max) <= 0){ $price_max = 0; }

        if(strlen($term) > 0 || $price_min > 0 || $price_max > 0)
        {
            $extra .= "  ";
            $has_search = true;
        }

        if($request->has('term'))
        {
            $term = $request->input('term');
            if(strlen($term) > 0)
            {
                $extra .= " (type LIKE '%$term%'";
                $extra .= " OR item LIKE '%$term%'";
                $extra .= " OR description LIKE '%$term%') ";
            }
        }

        if($request->has('term') && $request->has('price_min') &&  $request->has('price_max'))
        {
            $extra .= " AND ";
        }

        if($price_min >= 0 && $price_max > 0)
        {
            $extra .= (' (p.price >= '.(strlen($price_min) > 0 ? $price_min : '0').' AND price <='.(strlen($price_max) > 0 ? $price_max : '6').' )');
        }else if($price_min > 0 && $price_max == 0)
        {
            $extra.=('p.price >= '.$price_min);
        }else if($price_min === 0 && $price_max > 0)
        {
            $extra.=('p.price <= '.$price_max);
        }
        
        $itens_per_page = $request->input("itens_per_page", 24);
        $page = $request->input("page", 1);
        $page = $page - 1;
        $start = $page * $itens_per_page;
        $end =  $itens_per_page;//$start + $itens_per_page; //($page * $itens_per_page) + $itens_per_page;

        $id =  collect(DB::SELECT("SELECT id FROM product_brands WHERE route=?", [ $id ]))->first()->id;   

        $category = collect(DB::SELECT("SELECT * FROM product_brands WHERE id=?", [$id]))->first();        
        //$products =  DB::SELECT("SELECT * FROM products p WHERE (p.brand_id=$id ) " . $extra);
        $products = DB::SELECT("SELECT p.*, (SELECT location FROM product_images pim WHERE p.code=pim.product_id LIMIT 1) as image FROM products p  ". (strlen($extra) > 0 ? $extra. " AND " : " WHERE " )." (p.brand_id=$id )  LIMIT $start, $end;");

        $total_products = collect(DB::SELECT("SELECT count(*) total FROM products p WHERE (p.brand_id=$id ) " . $extra))->first()->total;
        $total_pages = ceil($total_products / $itens_per_page);

        $temp_page = $page + 1;
        $max_page = ($temp_page < ($total_pages - 3)) ? $temp_page + 3 : $total_pages;
        $min_page = ($temp_page - 3 >= 1) ? ($temp_page - 3) : $temp_page;

        if(Auth::guest())
        {
            $categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id AND p.active=1) > 0 LIMIT 20");
        }else{
            $user_test = Auth::user();

            if($user_test->self_register_user || $user_test->ic_admin)
            {
                $categories = DB::SELECT("SELECT * FROM product_brands pb WHERE (SELECT count(*) FROM products p WHERE p.brand_id=pb.id AND p.active=1) > 0 LIMIT 20");
            }else{
                $categories = DB::SELECT("SELECT pb.id, pb.name, pb.route FROM user_has_product_categories  up JOIN product_brands pb ON up.product_brand_id=pb.id WHERE up.user_id=? ORDER BY pb.name ASC", [$user_test->id]);
            }            
        }

        $types = DB::SELECT("SELECT * FROM product_types");
        $user = Auth::user();

        if(!empty($user))
        {
            $items = collect(DB::SELECT("SELECT sum(sc.quantity) as total FROM shopping_cart sc WHERE sc.user_id=?", [$user->id]))->first();
        }

        $banners = DB::SELECT("SELECT b.url_link, bi.location FROM banner_images bi JOIN banners b ON b.id=bi.banner_id WHERE now() BETWEEN b.start_date AND b.end_date");

        return view('welcome', ['controller' => 'HomeController','page_title' => $category->name, 'is_category' => true , 'has_search' => $has_search, 'total_products' => $total_products,  'price_min' => $price_min, 'price_max' => $price_max , 'min_page' => $min_page, 'max_page' => $max_page,'term' => $term, 'total_pages' => $total_pages, 'page' => ($page + 1), 'itens_per_page' => $itens_per_page, 'start' => $start, 'end' => $end,'products' => $products, 'categories' => $categories, 'category' => $category, 'types' => $types, 'user' => Auth::user(), 'total_items' => !empty($items) ? $items->total : 0, 'banners' => $banners]);
    }
}
