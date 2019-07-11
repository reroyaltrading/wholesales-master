<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Auth;
use DateTime;

class BannerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function banner_index(Request $request)
    {
        $user = Auth::user();
        return view('banner.index', ['user' => $user, 'controller' => 'BannerController']);
    }

    public function ajax_banners_get(Request $request)
    {
        $id = $request->input("id");
        $brand = collect(DB::SELECT("SELECT b.name, b.user_id, b.url_link, b.name, DATE_FORMAT(b.start_date, '%m/%d/%Y') as start_date, DATE_FORMAT(b.end_date, '%m/%d/%Y') as end_date  FROM banners b WHERE b.id=?", [$id]))->first();
        return response()->json($brand);
    }

    public function ajax_banners_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM banners b"))->first()->total;
        $total_pages = ceil($total / $items_per_page);       

        $banners = DB::SELECT("SELECT b.* FROM banners b ORDER BY b.name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('banners' => $banners, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_upload_banner(Request $request)
    {
        $nameFile = null;
        $upload = false;
        $destiny = "";
        $task_file_id = 0;
        $description = "";
        $product_image_id = 0;

        if ($request->hasFile('file') && $request->file('file')->isValid()) {
           
            try{
               $name = uniqid(date('HisYmd'));
               $extension = $request->file('file')->extension();
               $nameFile = "{$name}.{$extension}";
               $destiny = $request->file('file')->store('uploads'); 
               $upload = true; 
               $client_name = $request->file('file')->getClientOriginalName();

                $banner_image_id = DB::table('banner_images')->insertGetId(
                    ['name' => $name, 'original_name' => $client_name, 'location' => "app/".$destiny, 'extension' => $extension, 'user_id' => Auth::user()->id]
                );
            }catch(Exception $ex){
                $upload = false;
                $description = $ex->getMessage();
            }

        }

       return response()->json(array('uploaded' => $upload, 'banner_image_id' => $banner_image_id, 'storage' => "storage/app/".$destiny, 'file_name' => $nameFile, 'message' => $description));
    }

    public function ajax_banners_delete(Request $request)
    {
        $id = $request->input('id');
        DB::table('banners')->where('id', $id)->delete();
        return response()->json(array('deleted' => true));
    }

    public function ajax_banners_save(Request $request)
    {
        $name = $request->input("name");
        $start_date = $request->input("start_date");
        $end_date = $request->input("end_date");
        $url_link = $request->input("url_link");        

        $start_date_format = DateTime::createFromFormat('m/d/Y', $start_date);
        $start_date = $start_date_format->format('Y-m-d');

        $end_date_format =  DateTime::createFromFormat('m/d/Y', $end_date);
        $end_date = $end_date_format->format('Y-m-d');
        
        $request->validate([
            'name' => 'required|min:4|max:255',
        ]);

        if($request->has('id'))
        {
            $id = $request->input('id');
            DB::table('banners')->where('id', $id)->update(
                ['name' => $name, 'url_link' => $url_link, 'start_date' => $start_date_format, 'end_date' => $end_date_format]
            );
        }else{
            $id = DB::table('banners')->insertGetId(
                ['name' => $name, 'url_link' => $url_link, 'start_date' => $start_date_format, 'end_date' => $end_date_format   ]    
            );
        }

        DB::table('banner_images')->where('user_id', Auth::user()->id)->whereNull('banner_id')->update(['banner_id' => $id]);

        $data = array('created' => true, 'id' => $id);        
        return response()->json($data);
    }
}