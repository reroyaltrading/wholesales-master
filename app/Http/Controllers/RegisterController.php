<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function register_index(Request $request)
    {
        if(Auth::guest())
        {
        $countries = DB::SELECT("SELECT * FROM countries");
        return view('register.index', ['countries' => $countries, 'controller' => 'RegisterController']);
        }else
        {
            return redirect('/');  
        }
    }

    public function ajax_save_user(Request $request)
    {
        $name = $request->input("name");
        $email = $request->input("email");
        $phone = $request->input("phone");
        $password = $request->input("password");
        $repeat = $request->input("repeat");
        $address = $request->input("address");
        $city = $request->input("city");
        $country_id = $request->input("country_id");
        $state_id = $request->input("state_id");
        $zip_code = $request->input("zip_code");
        
        $warning = "";
        $alert = "";
        $title = "";
        $created = true;

        $samemail = collect(DB::select('select count(*) As total from users where email = ? ', [$email]))->first()->total;
        if($samemail == 0)
        {
            $title = "Sucess";
            $warning = "Sucess, an activation was sent for your email, please check your inbox!";
            $user_id = DB::table('users')->insertGetId(
                ['name' => $name, 'email' => $email, 'password' => md5($password), 'phone' => $phone, 'ic_admin' => 0,
                 'address' => $address, 'city' => $city, 'country_id' => $country_id,'state_id' => $state_id, 'zip_code' => $zip_code, 'self_register_user' => 1]
            );
            $alert = "success";
            $to_name = $name;
            $to_email = $email;

            $data = array('email' => $to_email, 'user_id' => $user_id, 'url' => 'https://wholesalecompany.ca/account/verify/'.md5($user_id), 'user_name' => $name);
            DB::table('users')->where ('id', $user_id) -> update(['hash' => md5($user_id)]);

            \Mail::send('emails.welcome', $data, function($message) use ($to_name, $to_email) {
                $message->to($to_email, $to_name)->subject('Welcome to WholeSales');
                $message->from('no-reply@blascke.com','WholeSales Canada');
            });

        }else
        {
            $verified = collect(DB::select('select count(*) As total from users where email = ? and email_confirm = 1', [$email]))->first()->total;
            if($verified == 0)
            {
                $title = "Please, verify your email";
                $warning="This account already registered. Another confirmation email was sent!";
             $user = collect(DB::table('users')->where ('email', $email)->get())->first();
             $user_id = $user->id;
             $data = array('email' => $email, 'user_id' => $user_id, 'url' => 'https://wholesalecompany.ca/account/verify/'.md5($user_id), 'user_name' => $name);
             \Mail::send('emails.welcome', $data, function($message) use ($name, $email) {
                $message->to($email, $name)->subject('Welcome to WholeSales');
                $message->from('no-reply@blascke.com','WholeSales Canada');
            });
            $alert = "warning";
            }
            else
            {
                $user_id = 0;
                $title = "ERROR";
                $warning = "email already registered.";
                $created = false;
                $alert = "error";
            }
        }
        
        return response()->json(array('created' => $created, 'id' => $user_id, 'warning' => $warning, 'alert' => $alert, 'title' => $title));
    }

    public function ajax_get_state_by_country(Request $request)
    {
        $id = $request->input("id");
        $states = DB::SELECT("SELECT * FROM country_states WHERE country_id=?", [$id]);
        return response()->json($states);
    }
}
