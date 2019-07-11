<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Auth;

class SupplierController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function suppliers_index(Request $request)
    {
        $user = Auth::user();

        if(!empty($user))
        {
            if($user->ic_admin)
            {
                $items = (new \App\Http\Helpers\StatusHelper())->GetMenuItems();
                return view('supplier.index', ['user' => $user, 'controller' => 'SupplierController', 'items' => $items]);
            }else{
                return Redirect::back()->withErrors(['msg', 'Not allowed']);
            }
        }else{
            return redirect('/');
        }
    }

    public function ajax_suppliers_list_all(Request $request)
    {
        $page = $request->input('page', 1);
        $items_per_page = $request->input('items_per_page', 25);
        $start_from = $page * $items_per_page;

        $total = collect(DB::SELECT("SELECT COUNT(*) as total FROM company_supplier s WHERE s.active=1"))->first()->total;
        $total_pages = ceil($total / $items_per_page);  
        
        $suppliers = DB::SELECT("SELECT * FROM company_supplier s WHERE s.active=1 ORDER BY name ASC LIMIT ? OFFSET ?", [$items_per_page, $start_from]);

        $data = array('suppliers' => $suppliers, 'page' => $page, 'items_per_page' => $items_per_page, 'total' => $total, 'total_pages' => $total_pages);

        return response()->json($data);
    }

    public function ajax_suppliers_delete_products(Request $request)
    {
        $supplier_id = $request->input("supplier_id", 0);
        $product_id = $request->input("product_id", 0);

        DB::table('product_has_suppliers')->where('supplier_id', $supplier_id)->where('product_id', $product_id)->delete();

        $products = DB::SELECT("SELECT * FROM products p JOIN product_has_suppliers phs ON phs.product_id=p.code WHERE phs.supplier_id=? ORDER BY p.item ASC", [$supplier_id]);
        $products_not = DB::SELECT("SELECT * FROM products p WHERE p.code NOT IN (SELECT phs.product_id FROM product_has_suppliers phs WHERE phs.supplier_id=?) ORDER BY p.item ASC", [$supplier_id]);

        return response()->json(array('products' => $products, 'products_not' => $products_not, 'deleted' => true));
    }

    public function ajax_suppliers_get_products(Request $request)
    {
        $supplier_id = $request->input("supplier_id", 0);
        $products = DB::SELECT("SELECT * FROM products p JOIN product_has_suppliers phs ON phs.product_id=p.code WHERE phs.supplier_id=? ORDER BY p.item ASC", [$supplier_id]);
        $products_not = DB::SELECT("SELECT * FROM products p WHERE p.code NOT IN (SELECT phs.product_id FROM product_has_suppliers phs WHERE phs.supplier_id=?) ORDER BY p.item ASC", [$supplier_id]);

        return response()->json(array('products' => $products, 'products_not' => $products_not));
    }

    public function ajax_suppliers_add_products(Request $request)
    {
        $supplier_id = $request->input("supplier_id", 0);
        $product_id = $request->input("product_id", 0);

        DB::table('product_has_suppliers')->insert(['supplier_id' => $supplier_id, 'product_id' => $product_id]);

        $products = DB::SELECT("SELECT * FROM products p JOIN product_has_suppliers phs ON phs.product_id=p.code WHERE phs.supplier_id=? ORDER BY p.item ASC", [$supplier_id]);
        $products_not = DB::SELECT("SELECT * FROM products p WHERE p.code NOT IN (SELECT phs.product_id FROM product_has_suppliers phs WHERE phs.supplier_id=?) ORDER BY p.item ASC", [$supplier_id]);

        return response()->json(array('products' => $products, 'products_not' => $products_not, 'created' => true));
    }

    public function ajax_suppliers_get(Request $request)
    {
        $id = $request->input("supplier_id", 0);
        $supplier = collect(DB::SELECT('SELECT * FROM company_supplier cs WHERE cs.id=?', [$id]))->first();
        return response()->json($supplier);
    }

    public function ajax_suppliers_save(Request $request)
    {
        $name = $request->input("name");
        $description = $request->input("description");
        $sales_email = $request->input("sales_email");
        $finance_mail = $request->input("finance_mail");
        $phone = $request->input("phone");
        $fax = $request->input("fax");
        $address = $request->input("address");
        $phone3cx = $request->input("phone3cx");
        $zipcode = $request->input("zipcode");
        $operation = $request->has("id") ? 'insert' : 'update';

        if($request->has("id"))
        {
            $id = $request->input("id");
            DB::table("company_supplier")->where('id', $id)->update([
                'name' => $name, 'description' => $description, 'address' => $address, 'phone3cx' => $phone3cx, 'zipcode' => $zipcode, 'fax' => $fax, 'sales_email' => $sales_email, 'finance_mail' => $finance_mail,
                'phone' => $phone, 'active' => 1
            ]);
        }else{
            $id = DB::table("company_supplier")->insertGetId([
                'name' => $name, 'description' => $description, 'address' => $address, 'phone3cx' => $phone3cx, 'zipcode' => $zipcode, 'fax' => $fax, 'sales_email' => $sales_email, 'finance_mail' => $finance_mail,
                'phone' => $phone, 'active' => 1
            ]);
        }

        return response()->json(array('created' => true, 'operation' => $operation, 'id' => $id));
    }

    public function ajax_suppliers_delete(Request $request)
    {
        $id = $request->input("supplier_id", 0);
        DB::table('company_supplier')->where('id', $id)->update(['active' => 0]);
        return response()->json(array("deleted" => true, "id" => $id));
    }
}
