<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use DB;

class FrontendController extends Controller
{
    public function index()
    {
        $items = DB::table('assign_products')
                    ->join('products', 'assign_products.product_id', '=', 'products.id')
                    ->join('additional_items', 'assign_products.additional_item_id', '=', 'additional_items.id')
                    ->select('assign_products.*', 'products.product_name', 'products.id as pid', 'additional_items.id as addid', 'additional_items.item_name')
                    ->where('assign_products.product_id','1')
                    ->get();
        
        // $products = Product::with('additionalItems.additionalItemTitle')->get();
        // $products = Product::with('additionalItems.additionalItemTitle')->where('id',1)->get();
        // dd($products);

        $products = Product::with('assignproduct')->get();
        return view('frontend.index', compact('products'));
    }

    public function getAdditionalProduct(Request $request)
        {

            $items = DB::table('assign_products')
                    ->join('products', 'assign_products.product_id', '=', 'products.id')
                    ->join('additional_items', 'assign_products.additional_item_id', '=', 'additional_items.id')
                    ->select('assign_products.*', 'products.product_name', 'products.id as pid', 'additional_items.id as addid', 'additional_items.item_name')
                    ->where('assign_products.product_id',$request->productid)
                    ->get();

            
            $products = Product::with('additionalItems.additionalItemTitle')->where('id',$request->productid)->get();
                    

            return response()->json(['status'=> 300,'items'=>$items,'products'=>$products]);

        }
}
