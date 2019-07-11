<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class WarehouseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function warehouse_index($id, Request $request)
    {
        
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('warehouse.index',['user'=>$user,'id' => $id, 'controller' => 'WarehouseController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function warehouse_list_items(Request $request)
    {

        $id = $request->input("id");
        $brand = DB::SELECT("SELECT p.item, poh.quantity, poh.purchase_order_id, p.items_on_box FROM  purchase_order_has_products poh JOIN products p ON p.CODE=poh.product_id WHERE poh.purchase_order_id=?", [$id]);
        return response()->json($brand);

    }

}