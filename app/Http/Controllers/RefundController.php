<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RefundController extends Controller
{
    public function refund_index(Request $request)
    {
        return view('refund.index', ['controller' => 'RefundController']);
    }
}
