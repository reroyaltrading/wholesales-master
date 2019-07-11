<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function category_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('category.index', ['user' => $user, 'controller' => 'CategoryController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_categories_get(Request $request)
    {
        $id = $request->input("id");
        $brand = collect(DB::SELECT("SELECT * FROM product_categories pc WHERE pc.id=?", [$id]))->first();
        return response()->json($brand);
    }

    public function ajax_categories_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM product_categories pc WHERE pc.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $categories = DB::SELECT("SELECT pc.* FROM product_categories pc  WHERE pc.active=1 ORDER BY pc.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('categories' => $categories, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_categories_delete(Request $request)
    {
        $id = $request->input('id');
        DB::table('product_categories')->where('id', $id)->update(['active' => 0]);
        return response()->json(array('deleted' => true));
    }

    public function ajax_categories_save(Request $request)
    {
        $name = $request->input("name");
        $description = $request->input("description");

        $request->validate([
            'name' => 'required|min:4|max:255',
        ]);

        if($request->has('id'))
        {
            $id = $request->input('id');
            DB::table('product_categories')->where('id', $id)->update(['name' => $name, 'description' => $description, 'active' => 1]);
        }else{
            $id = DB::table('product_categories')->insertGetId(['name' => $name, 'description' => $description, 'active' => 1]);
        }

        $data = array('created' => true, 'id' => $id);        
        return response()->json($data);
    }
}
