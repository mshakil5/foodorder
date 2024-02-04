<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\AdditionalItemTitle;
use Illuminate\Http\Request;
use DB;
use App\Models\Location;

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
        $products = Product::with('additionalItems.additionalItemTitle')->orderby('id','DESC')->limit(10)->get();
        $additems = AdditionalItemTitle::with('assignproduct')->get();
        

        $add_to_card_items = session('add_to_card_item', []);

        // dd($add_to_card_items);

        // $products = Product::with('assignproduct')->get();
        return view('frontend.index', compact('products','add_to_card_items'));
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
                $prop.= '<div class="col-md-12 box-custom mb-4 rounded-3">
                            <div class="row">
                                <div class="col-md-8 col-xs-12">
                                    <h4 style="margin-top: 0px" class="fw-bold text-primary">'.$product->product_name.'</h4>
                                    <p>'.$product->description.'</p>
                                </div>
                                <div class="col-md-2 col-xs-6">£'.number_format($product->price, 2).'</div>


                                <div class="col-md-2 col-xs-6">';

                            if ($product->assign == 1) {
                                
                                $prop.= '<button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';

                            } else {
                                
                                $prop.= '<button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';
                            }
                            
                            $prop.='</div></div></div>';
            }



            return response()->json(['status'=> 303,'product'=>$prop]);

        }
    // end search 



    // search by name
    
    public function searchProductbyName(Request $request)
    {

        $searchdata = $request->searchdata;

        if (isset($searchdata)) {
            $products = Product::with('additionalItems.additionalItemTitle')->where([
                ['product_name', 'LIKE', "%{$searchdata}%"]
            ])->limit(20)->orderby('id','DESC')->get();
        } else {
            $products = Product::with('additionalItems.additionalItemTitle')->get();
        }
        

        $prop = '';
        
        foreach ($products as $product){
            // <!-- Single Property Start -->
            $prop.= '<div class="col-md-12 box-custom mb-4 rounded-3">
                        <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <h4 style="margin-top: 0px" class="fw-bold text-primary">'.$product->product_name.'</h4>
                                <p>'.$product->description.'</p>
                            </div>
                            <div class="col-md-2 col-xs-6">£'.number_format($product->price, 2).'</div>


                            <div class="col-md-2 col-xs-6">';

                        if ($product->assign == 1) {
                            
                            $prop.= '<button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';

                        } else {
                            
                            $prop.= '<button class="btn btn-primary text-uppercase btn-sm btn-modal" data-toggle="modal" data-target="#additemModal" style="margin-left: -7px;" pid="'.$product->id.'" pname="'.$product->product_name.'" pdesc="'.$product->description.'" price="'.number_format($product->price, 2).'"> add </button>';
                        }
                        
                        $prop.='</div></div></div>';
        }

            return response()->json(['status'=> 303,'product'=>$prop]);

        }
        
    // search by name end



    public function checkPostCode(Request $request)
    {

        $searchdata = substr($request->postcode, 0, 3);

        $data = Location::where('postcode', 'like', '%'.$request->postcode.'%')->orWhere('postcode', 'like', '%'.$searchdata.'%')->first();

        if (isset($data) ) {
            $message ="<b style='color: green'>Available</b>";
            return response()->json(['status'=> 300,'data'=>$data,'message'=>$message]);
        } else {
            $message ="<b style='color: red'>This location is out of our service.</b>";
            return response()->json(['status'=> 303,'message'=>$message]);
        }
        

    }

    public function clearAllSessionData()
    {
        $items = DB::table('assign_products')
                    ->join('products', 'assign_products.product_id', '=', 'products.id')
                    ->join('additional_items', 'assign_products.additional_item_id', '=', 'additional_items.id')
                    ->select('assign_products.*', 'products.product_name', 'products.id as pid', 'additional_items.id as addid', 'additional_items.item_name')
                    ->where('assign_products.product_id','1')
                    ->get();
        
        // $products = Product::with('additionalItems.additionalItemTitle')->get();
        $products = Product::with('additionalItems.additionalItemTitle')->orderby('id','DESC')->limit(10)->get();
        $additems = AdditionalItemTitle::with('assignproduct')->get();
        

        $add_to_card_items = session('add_to_card_item', []);

        // dd($add_to_card_items);

        session()->flush();
        session()->regenerate();

        // $products = Product::with('assignproduct')->get();
        return view('frontend.index', compact('products','add_to_card_items'));
    }

}
