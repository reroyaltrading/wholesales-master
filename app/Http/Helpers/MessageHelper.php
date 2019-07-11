<?php

namespace App\Http\Helpers;

use Illuminate\Http\Request;
use Auth;

class MessageHelper
{
    public function ApplyCode($text, $array)
    {
        foreach($array as $item)
        {
           $text = str_replace($item['name'], $item['value'], $text);
        }

        $text = str_replace("[", "", $text);
        $text = str_replace("]", "", $text);

        return $text;
    }
}