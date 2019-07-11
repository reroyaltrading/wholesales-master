<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HelpController extends Controller
{
    public function help_index(Request $request)
    {
        return view('help.index', ['controller' => 'HelpController']);
    }
}
