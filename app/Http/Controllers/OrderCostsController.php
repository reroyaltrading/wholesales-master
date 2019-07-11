<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class OrderCostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function orders_costs_index($id)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                $status = collect(DB::SELECT("SELECT * FROM purchase_status ps WHERE ps.id=?", [$id]))->first();
                return view('order.costs', ['user' => $user, 'order_id' => $id,'controller' => 'OrderCostsController', 'items' => $items, 'status_id' => $id, 'status' => $status]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_order_costs_list(Request $request)
    {
        $order_id = $request->input("order_id");
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM purchase_order_costs poc WHERE poc.purchase_order_id=?", [$order_id]))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $costs = DB::SELECT("SELECT poc.* FROM purchase_order_costs poc  WHERE poc.purchase_order_id=? ORDER BY poc.id ASC LIMIT ? OFFSET ?", [ $order_id,$items_per_page, $start_from]);

        $data = array('costs' => $costs, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_order_costs_save(Request $request)
    {
        $order_id = $request->input("order_id");
        $name = $request->input("name");
        $value = $request->input("value");
        $user_id = $request->input("user_id", Auth::user()->id);

        $data_array = array("name" => $name, "value" => $value, "purchase_order_id" => $order_id, "user_id" => $user_id);

        if($request->has("id"))
        {
            $id = $request->input("id");
            DB::table('purchase_order_costs')->where('id', $id)->update($data_array); 
        }else{
            $id = DB::table('purchase_order_costs')->insertGetId($data_array); 
        }

        return response()->json(array('created' => true, 'id' => $id));
    }

    public function ajax_order_costs_get(Request $request)
    {
        $cost_id = $request->input("cost_id");
        $cost = collect(DB::table('purchase_order_costs')->where('id', $cost_id)->get())->first();
        return response()->json($cost);
    }

    public function ajax_order_costs_delete(Request $request)
    {
        $id = $request->input("cost_id");
        DB::table('purchase_order_costs')->where('id', $id)->delete();
        return response()->json(array('deleted' => true));
    }
}