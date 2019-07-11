<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Rap2hpoutre\FastExcel\FastExcel;
use App\OrderExport;
use App\SupplierContact;
use Auth;

class ExcelController extends Controller{

    public function export_order()
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
        $users = OrderExport::all();
        $name = uniqid(date('HisYmd')).'.xlsx';
        (new FastExcel($users))->export($name);
        return redirect('/'.$name);
    }else{
        return Redirect::back()->withErrors(['msg', 'Not allowed']);
    }
}else{
    return redirect('/');
}
    }
    public function export_contacts()
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
        $users = SupplierContact::all();
        $name = uniqid(date('HisYmd')).'.xlsx';
        (new FastExcel($users))->export($name);
        return redirect('/'.$name);
    }else{
        return Redirect::back()->withErrors(['msg', 'Not allowed']);
    }
}else{
    return redirect('/');
}
    }
}

?>