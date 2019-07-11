<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function admin_index ()
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $total_users = collect(DB::SELECT("SELECT count(*) as total FROM users"))->first()->total;
                $total_orders = collect(DB::SELECT("SELECT count(*) as total FROM purchase_order"))->first()->total;
                $ticket = collect(DB::SELECT("SELECT SUM(total) / (SELECT count(*) FROM purchase_order) as total FROM purchase_order "))->first()->total;

                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();

                return view('admin.index', ['items' => $items, 'user' => $user, 'total_users' => $total_users, 'total_orders' => $total_orders, 'ticket' => $ticket]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }
}
