<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Auth;

class SmsHelper
{
    public function SendMessage($phone, $message)
    {
        $response = array();

        if(!empty($phone) && !empty($message))
        {

            try {
                $params = array(
                    'credentials' => array(
                        'key' => env('AWS_ACCESS_KEY_ID'), //config('aws.credentials.key'),
                        'secret' => env('AWS_SECRET_ACCESS_KEY'),//config('aws.credentials.secret'),
                    ),
                    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),//config('aws.region'), 
                    'version' => 'latest'
                );

                //print_r($params);
            
                $sns = new \Aws\Sns\SnsClient($params);
            
                $args = array(
                    "MessageAttributes" => [
                                'AWS.SNS.SMS.SenderID' => [
                                    'DataType' => 'String',
                                    'StringValue' => 'M0153268977'
                                ],
                                'AWS.SNS.SMS.SMSType' => [
                                    'DataType' => 'String',
                                    'StringValue' => 'Transactional'
                                ]
                            ],
                        "Message" =>  $message,
                        "PhoneNumber" => $phone
                );        
        
            
                //$response = true;
                $response['success'] = $sns->publish($args) ? true : false;
            } catch (Exception $e) {
                $response['success'] = false;
                $response['errorno'] = '500';
                $response['exception'] = $e->getMessage();

                $response = false;
            }
        }else{
            $response['success'] = false;
            $response['exception'] = 'Error. 401 Unauthorized. The request has not been applied because it lacks valid authentication credentials for the target resource';
            $response['errorno'] = '401';
        }

        return $response;
    }
}