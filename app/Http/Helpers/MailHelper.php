<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Auth;

class MailHelper
{
    public function SendMail($email, $message, $description, $name)
    {
        $response = array();
        try
        {
            $data = array('content' => $message);
            
            \Mail::send('emails.contact', $data, function($message) use ($email, $name, $description)
            {    
                $message->to($email, $name)->subject($description);
                $message->from('no-reply@blascke.com','WholeSales Canada');    
            });


            $response['success'] =  true;
        }catch(Exception $ex)
        {
            $response['success'] = false;
            $response['exception'] = $ex->GetMessage();
            $response['errorno'] = '401';
        }

        return $response;
    }

    public static function ValidateEmail($email)
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}