<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;

class StatusHelper
{
    public function GetMenuItems()
    {
        $user_id = Auth::user()->id;
        $items = DB::SELECT("SELECT ps.name, ps.id, (SELECT COUNT(*) FROM purchase_order po WHERE po.status_id=ps.id) as total FROM purchase_status ps WHERE pin_menu_bar=1 ORDER BY menu_order ASC");
        return $items;
    }
}