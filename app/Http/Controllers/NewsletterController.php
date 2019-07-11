<?php

namespace App\Http\Controllers;

use App\Http\Helpers\MailHelper;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class NewsletterController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function news_index (Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('newsletter.index', ['user' => $user, 'controller' => 'NewsletterController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_get_all_brands(Request $request)
    {
        $brands = DB::SELECT("SELECT * FROM product_brands WHERE active=1 ORDER BY name ASC");
        return response()->json($brands);
    }

    public function ajax_list_all_mails(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM maillings"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $mails = DB::SELECT("SELECT m.*, DATE_FORMAT(created_at, '%m/%d/%Y') as created_date FROM maillings m ORDER BY m.id DESC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('mails' => $mails, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_delete_contact(Request $request)
    {
        $id = $request->input('id');
        DB::table('maillings')->where('id', $id)->delete();
        return response()->json(array('deleted' => true, 'id' => $id));
    }

    public function ajax_save_contact(Request $request)
    {
        $email = $request->input('email');
        $message = $request->input('message');
        $name = $request->input('name');

        $id = DB::table('supplier_contact')->insertGetId(['email' => $email, 'name' => $name, 'message' => $message]);

        $content =  "New message from: ".$name." ($email): ". $message;
        $data = array('content' => $content, 'url' => "https://wholesalecompany.ca/admin/contacts.html");
       
        $emails = DB::SELECT("SELECT email FROM users WHERE ic_admin=1");

        $mails_send = array();
        foreach($emails as $email)
        {
            $mails_send[] = $email;
        }

        \Mail::send('emails.contact', $data, function($message) use ($mails_send)
        {    
            $message->to($mails_send)->subject($maillings->name);    
        });

        return response()->json(array('created' => true, 'id' => $id));
    }

    public function ajax_get_mail(Request $request)
    {
        $id = $request->input("id");
        $mail = collect(DB::select('select * from maillings where id = ?', [$id]))->first();
        return response()->json($mail);
    }

    public function ajax_save_mail(Request $request)
    {
        $content = $request->input("content");
        $name = $request->input("name");
        $description = $request->input("description");
        $send_to_buyers = $request->input("send_to_buyers");
        $brand_id = $request->input("brand_id");

        if($request->has('id'))
        {
            $id = $request->input("id");
            $id = DB::table('maillings')->where('id', $id)->update(['content' => $content, 'name' => $name, 'description' => $description, 'send_to_buyers' => $send_to_buyers, 'brand_id' => $brand_id]);
        }else{
            $id = DB::table('maillings')->insertGetId(['content' => $content, 'name' => $name, 'description' => $description, 'send_to_buyers' => $send_to_buyers, 'brand_id' => $brand_id]);
        }

        return response()->json(array('created' => true, 'id' => $id));
    }

    public function ajax_send_mail(Request $request)
    {
        $id = $request->input("id");
        $maillings = collect(DB::SELECT("SELECT * FROM maillings m WHERE m.id=?", [$id]))->first();

        if($maillings->send_to_buyers)
        {
            $mails = DB::SELECT("SELECT v.name, v.email FROM view_all_users_on_purchase_brand v WHERE v.brand_id=?
                    UNION ALL 
                    SELECT '' as name, s.email FROM mail_subscription s", [$maillings->brand_id]);
        }else{
            $mails = DB::SELECT("SELECT '' as name, s.email FROM mail_subscription s");
        }

        $mails_send = array();

        foreach($mails as $mail)
        {
            if(MailHelper::ValidateEmail($mail->email)){
                $mails_send[] = $mail->email;
            }
        }

        $data = array('content' => $maillings->content);

        \Mail::send('emails.dynamic', $data, function($message) use ($mails_send, $maillings)
        {    
            $message->to($mails_send)->subject($maillings->name);    
        });

        return response()->json(array('created' => true));
    }
}
