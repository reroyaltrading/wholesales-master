<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function contact_index(Request $request)
    {
        $user = Auth::user();
        return view('contact.index', ['user' => $user, 'controller' => 'ContactController']);
    }

    public function ajax_list_all(Request $request)
    {
        $contacts = DB::SELECT("SELECT * FROM supplier_contact ORDER BY id DESC");
        return response()->json($contacts);
    }

    public function ajax_delete_contact(Request $request)
    {
        $id = $request->input("contact_id");
        DB::table("supplier_contact")->where('id', $id)->delete();
        return response()->json(array('deleted' => true));
    }

    public function ajax_response_contact(Request $request)
    {
        $id = $request->input("id");
        $message = $request->input("message");

        $data = array('content' => $message);

        $user = Auth::user();
        $response_to = collect(DB::SELECT("SELECT * FROM supplier_contact WHERE id=?", [$id]))->first();

        if(!empty($response_to))
        {
            $to_email = $response_to->email;
            $to_name = $response_to->name;
            
            \Mail::send('emails.contact', $data, function($message) use ($to_email, $to_name)
            {    
                $message->to($to_email, $to_name)->subject('Supplier contact');
                $message->from('no-reply@blascke.com','WholeSales Canada');    
            });

            $response_id = DB::table('supplier_contact_responses')->insertGetId(['user_id' => $user_id, 'message' => $message, 'contact_id' => $id]);

            $my_response = array('sent' => true, 'response_id' => $response_id);
        }else{
            $my_response = array('sent' => false);
        }

        return response()->json($my_response);
    }
}
