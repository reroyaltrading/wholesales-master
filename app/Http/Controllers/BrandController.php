<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class BrandController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function brand_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('brand.index', ['user' => $user, 'controller' => 'BrandController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_brands_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM product_brands pb WHERE pb.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $brands = DB::SELECT("SELECT pb.* FROM product_brands pb  WHERE pb.active=1 ORDER BY pb.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('brands' => $brands, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_brands_get(Request $request)
    {
        $id = $request->input("id");
        $brand = collect(DB::SELECT("SELECT * FROM product_brands pb WHERE pb.id=?", [$id]))->first();
        return response()->json($brand);
    }

    public function ajax_brands_delete(Request $request)
    {
        $id = $request->input('id');
        DB::table('product_brands')->where('id', $id)->update(['active' => 0]);
        return response()->json(array('deleted' => true));
    }

    public function ajax_brands_save(Request $request)
    {
        $name = $request->input("name");
        $route = $request->input("route");

        $request->validate([
            'route' => 'required|min:4|max:255',
            'name' => 'required|min:4|max:255',
        ]);

        $isRouteValid = collect(DB::SELECT("SELECT COUNT(*) as total FROM product_brands pb WHERE pb.route=?", [$route]))->first()->total <= 0;

        if($isRouteValid || $request->has('id'))
        {
            if($request->has('id'))
            {
                $id = $request->input('id');
                DB::table('product_brands')->where('id', $id)->update(['name' => $name, 'route' => $route, 'active' => 1]);
            }else{
                $id = DB::table('product_brands')->insertGetId(['name' => $name, 'route' => $route, 'active' => 1]);
            }

            $data = array('created' => true, 'id' => $id);
        }else{
            $errors = array('route' => array('Route already is been taken'));
            $data = array('created' => false, 'errors' => $errors, 'message' => 'The given data was invalid.');
        }
        
        return response()->json($data);
    }
}
