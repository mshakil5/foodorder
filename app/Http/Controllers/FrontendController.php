<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AdditionalItemTitle;
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
        $products = Product::with('additionalItems.additionalItemTitle')->get();
        $additems = AdditionalItemTitle::with('assignproduct')->get();
        // dd($additems);

        // $products = Product::with('assignproduct')->get();
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

    //    search property start

    public function searchproduct(Request $request){

        $id = $request->id;

        $products = Product::where('category_id', $id)->get();
        
 
        

        $prop = '';
        


            foreach ($products as $product){
                // <!-- Single Property Start -->
                $prop.= '<div class="col-md-9 col-xs-12">
                            <h3 style="margin-top: 0px">'.$product->name.'</h3>
                            <p>'.$product->description.'</p>
                            <input type="text" placeholder="Note" style="width:100%;border:1px solid black;margin-bottom:20px;" />
                        </div>
                        <div class="col-md-2 col-xs-6">£'.number_format($product->price, 2).'</div>
                        <div class="col-md-1 col-xs-6">';

                            if ($product->assign == 1) {
                                
                                $prop.= '<button class="btn btn-primary btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';

                            } else {
                                
                                $prop.= '<button class="btn btn-primary btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';

                                // $prop.='<button class="btn btn-primary btn-sm" style="margin-left: -7px;"  id="addToCard" pqty="1" pid="'.$product->id.'" net_amount="'.number_format($product->price, 2).'" price="'.number_format($product->price, 2).'" pname="'.$product->product_name.'">Add</button>';
                            }
                            
                            $prop.='</div>';
                            
                }

            return response()->json(['status'=> 303,'product'=>$prop]);

        }
    // end search property 
}
