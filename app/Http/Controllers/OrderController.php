<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function orders_index()
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('order.index', ['user' => $user, 'controller' => 'OrderController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function orders_index_by_status($id)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                $status = collect(DB::SELECT("SELECT * FROM purchase_status ps WHERE ps.id=?", [$id]))->first();
                return view('order.index', ['user' => $user, 'controller' => 'OrderController', 'items' => $items, 'status_id' => $id, 'status' => $status]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_save_note(Request $request)
    {
        $description = $request->input("description");
        $order_id =  $request->input("order_id");
        $user_id = Auth::user()->id;

        $id = DB::table('purchase_order_note')->insertGetId(['description' => $description, 'order_id' => $order_id, 'user_id' => $user_id]);
        return response()->json(array('created' => true, 'id' => $id));
    }

    public function ajax_order_status_log(Request $request)
    {
        $order_id = $request->input('order_id');
        $log = DB::SELECT("SELECT poscl.*, DATE_FORMAT(poscl.created_at,'%m/%d/%Y') as created_date,
        u.name as username, ps.name as previous_status_name, pt.name as current_status_name  FROM purchase_order_status_change_log poscl 
        JOIN users u ON u.id=poscl.user_id JOIN purchase_status ps ON ps.id=poscl.previous_status_id
        JOIN purchase_status pt ON pt.id=poscl.current_status_id
        WHERE purchase_order_id=?", [$order_id]);
        return response()->json($log);
    }

    public function ajax_order_status_change(Request $request)
    {
        $order_id = $request->input('order_id');
        $status_id = $request->input('status_id');
        $user = Auth::user();

        $purchase_order = collect(DB::table("purchase_order")->where('id', $order_id)->get())->first();

        $current_status = collect(DB::SELECT("SELECT * FROM purchase_status WHERE id=?", [$status_id]))->first();
        $current_user = collect(DB::SELECT("SELECT * FROM users u WHERE u.id=?", [$purchase_order->user_id]))->first();


        $is_sms_sent = false;
        $is_mail_sent = false;

        $messageHelper =  new \App\Http\Helpers\MessageHelper();

        $array_change = array(
            array('name' => '[order_id]', 'value' => $order_id),
            array('name' => '[status_name]', 'value' => $current_status->name),
            array('name' => '[user_name]', 'value' => $current_user->name),
            array('name' => '[status_id]', 'value' => $current_status->id),
            array('name' => '[date_time]', 'value' => date('m/d/Y')),
        );

        $message = $messageHelper->ApplyCode($current_status->message_content, $array_change);

        if($current_status->send_mail)
        {
            //$message = "Your order number #". $order_id. " has its status changed to ". $current_status->name;
            $mailHelper = new \App\Http\Helpers\MailHelper();
            $mail_response = $mailHelper->SendMail($current_user->email, $message, "Order status changed", $current_user->name);
            $is_mail_sent = $mail_response['success'];
        }

        if($current_status->send_sms)
        {
            //$message = "Your order number #". $order_id. " has its status changed to ". $current_status->name;
            $smsHelper = new \App\Http\Helpers\SmsHelper();
            $sms_response = $smsHelper->SendMessage($current_user->phone, $message);
            $is_sms_sent = $sms_response['success'];
        }

        DB::table('purchase_order_status_change_log')->insertGetId([
            'user_id' => $user->id, 'previous_status_id' => $purchase_order->status_id, 'current_status_id' => $status_id, 'purchase_order_id' => $order_id
        ]);

        DB::table('purchase_order')->where('id', '=', $order_id)->update(
            ['status_id' => $status_id]
        );

        return response()->json(array('created' => true, 'status_id' => $status_id, 'sms_sent' => $is_sms_sent, 'mail_sent' => $is_mail_sent));
    }

    public function orders_get_index($id)
    {
        $order = collect(DB::SELECT("SELECT po.*, u.name as user_name, u.email as user_email, u.phone as user_phone, '' as user_address FROM purchase_order po JOIN users u ON u.id=po.user_id WHERE po.id=?", [$id]))->first();
        $order_products = DB::SELECT("SELECT poh.purchase_order_id, p.item as product_name, p.price as product_price, poh.quantity as product_quantity, poh.quantity * poh.price as price_sub_total FROM purchase_order_has_products poh JOIN products p ON p.code=poh.product_id where poh.purchase_order_id=?", [$id]);
        $user = Auth::user();
        $order_notes = DB::SELECT("SELECT pon.*, u.name as user_name FROM purchase_order_note pon JOIN users u ON pon.user_id=u.id WHERE pon.order_id=?", [$id]);
        return view('order.view_order', ['user' => $user, 'order' => $order, 'order_products' => $order_products, 'order_notes' => $order_notes]);
    }

    public function ajax_statuses_list_all()
    {
        $statuses = DB::select('select * from purchase_status ps ORDER BY ps.menu_order ASC');
        return response()->json($statuses);
    }

    public function ajax_getall_contact_order(Request $request)
    {
        $order_id = $request->input('order_id');
        $messages = DB::SELECT("SELECT po.message, DATE_FORMAT(po.created_at, '%m/%d/%Y') as created_at, u.name as user_name FROM purchase_order_contacts po JOIN users u ON u.id=po.user_id WHERE po.order_id=? ORDER BY created_at DESC", [$order_id]);
        return response()->json($messages);
    }

    public function ajax_save_contact_order(Request $request)
    {
        $order_id = $request->input("order_id");
        $message = $request->input("message");
        $user = Auth::user();
        $created_at = date('Y-m-d');

        $contact_id = DB::table('purchase_order_contacts')->insertGetId([
            'user_id' => $user->id, 'order_id' => $order_id, 'message' => $message, 'created_at' => $created_at
        ]);

        $data = array('created' => true, 'id' => $contact_id);
        return response()->json($data);
    }

    public function ajax_orders_index_by_status(Request $request)
    {
        $page = $request->input('page', 1);
        $status_id = $request->input('status_id');
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM purchase_order po WHERE po.status_id=? ", [$status_id]))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $orders = DB::SELECT("SELECT po.*, DATE_FORMAT(po.created_at, '%M %d %Y') as date, u.name as user_name, u.phone as user_phone, u.email as user_email, ps.name as status_name, ps.id as status_id
        FROM purchase_order po JOIN users u ON u.id=po.user_id JOIN purchase_status ps ON ps.id=po.status_id WHERE po.active=1 AND po.status_id=? ORDER BY po.id DESC LIMIT ? OFFSET ?", [$status_id,$items_per_page, $start_from]);

        $data = array('orders' => $orders, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_orders_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM purchase_order po"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $orders = DB::SELECT("SELECT po.*, DATE_FORMAT(po.created_at, '%M %d %Y') as date, u.name as user_name, u.phone as user_phone, u.email as user_email, ps.name as status_name, ps.id as status_id
        FROM purchase_order po JOIN users u ON u.id=po.user_id JOIN purchase_status ps ON ps.id=po.status_id WHERE po.active=1 ORDER BY po.id DESC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('orders' => $orders, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }
}
