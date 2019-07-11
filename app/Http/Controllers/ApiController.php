<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class ApiController extends Controller
{
    public function api_list_items($id)
    {
        $items = DB::SELECT("SELECT p.item, poh.quantity, poh.purchase_order_id, p.items_on_box FROM  purchase_order_has_products poh JOIN products p ON p.CODE=poh.product_id WHERE poh.purchase_order_id=?", [$id]);
        return response()->json($items);
    }
    public function ajax_list_orders()
    {
        $orders = DB::SELECT("SELECT * FROM purchase_order a WHERE a.status_id = 2 AND a.active = 1");
        return response()->json($orders);
    }
}