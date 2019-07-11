<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;
use Redirect;
use Session;

class LoginContoller extends Controller
{
    public function auth_get_logout()
    {
        Auth::logout();
        return redirect()->route('home_index')->withCookie(cookie()->forget('remember_me'));
    }
public function verify_account($hash)
{
        DB::table('users')->where('hash', $hash)->update(['email_confirm' => 1]);
        $total = collect(DB::select('select count(*) AS total from users where hash = ? and email_confirm=1', [$hash]))->first()->total;
        if($total > 0)
        {
            return redirect ('login.html');
        }
        else 
        {
            return redirect ('404.html');
        }
}
    public function recover_index(Request $request)
    {
        if(Auth::guest())
        {
            return view('account.recovery', ['controller'=>'LoginController']);
        }else{
            return view('error.error404');
        }
    }

    public function ajax_recover_index(Request $request)
    {
        $email = $request->input('user_email');
        $user = collect(DB::SELECT('SELECT * FROM users u WHERE u.email=?', [$email]))->first();

        $hash = md5($user->email.'AXZF'.$user->id.date('y-m-d h:m:s'));

        DB::table("password_recoveries")->insertGetId(
            ['user_id' => $user->id, 'hash' => $hash]
        );

        $to_name = $user->name;
        $to_email = $user->email;

        $data = array('email' => $to_email, 'user_id' => $user->id, 
        'url' => 'https://wholesalecompany.ca/account/recovery/confirm/'.$hash, 'user_name' => $user->name);

        \Mail::send('emails.recovery', $data, function($message) use ($to_name, $to_email) {
            $message->to($to_email, $to_name)->subject('Password recovery');
            $message->from('no-reply@blascke.com','WholeSales Canada');
        });

        return response()->json(array('created' => true));
    }

    public function ajax_recover_complete_index(Request $request)
    {
        $password = $request->input("password");
        $hash = $request->input("hash");

        $user = collect(DB::SELECT("SELECT u.* FROM password_recoveries pr JOIN users u ON u.id=pr.user_id WHERE pr.hash=?", [$hash]))->first();

        DB::table('users')->where('id', $user->id)->update(
            ['password' => md5($password) ]
        );

        return response()->json(array('created' => true));
    }

    public function recover_confirm_index($hash)
    {
        $user = collect(DB::SELECT("SELECT u.* FROM password_recoveries pr JOIN users u ON u.id=pr.user_id WHERE pr.hash=?", [$hash]))->first();
        if(!empty($user))
        {
            return view('account.done_recovery', ['user' => $user, 'hash' => $hash, 'controller'=>'LoginController']);
        }else{
            return view('error.error404');
        }
    }

    public function ajax_login_via_token(Request $request)
    {
        $token = $request->input("token");
        $user = collect(DB::SELECT(" SELECT * FROM users WHERE remember_token=?", [$token]))->first();

        $auth = false;
        $hasCookie = true;
        $remember_token = "";

        $cookie = "";

    	if(!empty($user))
    	{
    		$auth = true;
            $user = Auth::loginUsingId($user->id);

            return redirect()->route('admin_console')->withCookie(cookie()->forever('remember_token',  $remember_token));
        }else{
            return view('error.error404');
        }
    }

    public function  login_index(Request $request)
    {
        if(Auth::guest())
        {
            return view('login.index', ['controller' => 'LoginController']);
        }else{
            return redirect('/index.html');
        }
    }

    public function ajax_post_login(Request $request)
    {
    	$username = $request->input('username');
        $password = $request->input('password');
        $remember = $request->input('remember', true);

    	$user = collect(DB::SELECT(" SELECT * FROM users WHERE email=? AND password=?", [$username , md5($password)]))->first();

        $auth = false;
        $hasCookie = true;
        $remember_token = "";

        $cookie = "";

    	if(!empty($user))
    	{
    		$auth = true;
            $user = Auth::loginUsingId($user->id);
            
            if($remember)
            {
                //UPDATE users SET remember_token='' WHERE remember_token IS NULL AND id=1
                $hasCookie = true;
                \App\User::where('id', 1)->whereNull('remember_token')->update(['remember_token' => str_random(20)]);
                $user_token = collect(DB::SELECT(" SELECT remember_token FROM users WHERE id=?", [$user->id]))->first();
                $remember_token = $user_token->remember_token;
            }
    	}

        if($hasCookie)
        {
            return response()->json(array( 'auth' => $auth, 'user' => $user, 'remember_token'=> $remember_token))
            ->withCookie(cookie()->forever('remember_token',  $remember_token));
        }else{
            return response()->json(array( 'auth' => $auth, 'user' => $user, 'remember_token'=> $remember_token));
        }
    }
}
