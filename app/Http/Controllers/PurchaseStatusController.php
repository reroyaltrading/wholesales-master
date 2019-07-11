<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class PurchaseStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function purchase_order_statuses_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('order_status.index', ['user' => $user, 'controller' => 'OrderStatusController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_order_status_get(Request $request)
    {
        $id = $request->input("id");
        $brand = collect(DB::SELECT("SELECT ps.* FROM purchase_status ps", [$id]))->first();
        return response()->json($brand);
    }

    public function ajax_order_status_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM purchase_status ps WHERE ps.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $statuses = DB::SELECT("SELECT ps.* FROM purchase_status ps  WHERE ps.active=1 ORDER BY ps.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('statuses' => $statuses, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_order_status_delete(Request $request)
    {
        $id = $request->input('id');
        DB::table('purchase_status')->where('id', $id)->update(['active' => 0]);
        return response()->json(array('deleted' => true));
    }

    public function ajax_order_status_save(Request $request)
    {
        $name = $request->input("name");
        $description = $request->input("description");
        $message_content = $request->input("message_content");
        $email_subject = $request->input("email_subject");
        $send_sms = $request->input("send_sms", 0);
        $send_mail = $request->input("send_mail", 0);
        $pin_menu_bar = $request->input('pin_menu_bar', 0);

        $request->validate([
            'name' => 'required|min:4|max:255',
        ]);

        if($request->has('id'))
        {
            $id = $request->input('id');
            DB::table('purchase_status')->where('id', $id)->update(
                ['name' => $name, 'pin_menu_bar' => $pin_menu_bar,'message_content' => $message_content, 'email_subject' => $email_subject,'description' => $description, 'active' => 1, 'send_mail' => $send_mail ? 1 : 0, 'send_sms' => $send_sms ? 1 : 0]);
        }else{
            $id = DB::table('purchase_status')->insertGetId(
                ['name' => $name, 'pin_menu_bar' => $pin_menu_bar,'message_content' => $message_content, 'email_subject' => $email_subject,'description' => $description, 'active' => 1, 'send_mail' => $send_mail ? 1 : 0, 'send_sms' => $send_sms ? 1 : 0]);
        }

        $data = array('created' => true, 'id' => $id);        
        return response()->json($data);
    }
}
