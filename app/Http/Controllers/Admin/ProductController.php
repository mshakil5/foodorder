<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdditionalItem;
use Illuminate\Http\Request;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use App\Models\AdditionalItemTitle;
use App\Models\AssignProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        $data = Product::orderby('id','DESC')->get();
        $brands = Brand::orderby('id','DESC')->get();
        $category = Category::orderby('id','DESC')->get();
        return view('admin.product.index', compact('data','brands','category'));
    }

    public function store(Request $request)
    {
        if(empty($request->product_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Product Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }

        $data = new Product;
        // image
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images/product'), $imageName);
            $data->image= $imageName;
        }
        // end
        $data->product_name = $request->product_name;
        $data->brand_id = $request->brand_id;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->stock_qty = $request->stock_qty;
        $data->price = $request->price;
        $data->created_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Create Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        }
    }

    public function edit($id)
    {
        $where = [
            'id'=>$id
        ];
        $info = Product::where($where)->get()->first();
        return response()->json($info);
    }

    public function update(Request $request)
    {

        
        if(empty($request->product_name)){
            $message ="<div class='alert alert-warning'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Please fill \"Product Name \" field..!</b></div>";
            return response()->json(['status'=> 303,'message'=>$message]);
            exit();
        }


        $data = Product::find($request->codeid);
        // image
        if ($request->image != 'null') {
            $request->validate([
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg,pdf|max:8048',
            ]);
            $rand = mt_rand(100000, 999999);
            $imageName = time(). $rand .'.'.$request->image->extension();
            $request->image->move(public_path('images/product'), $imageName);
            $data->image= $imageName;
        }
        // end
        $data->product_name = $request->product_name;
        $data->brand_id = $request->brand_id;
        $data->category_id = $request->category_id;
        $data->description = $request->description;
        $data->stock_qty = $request->stock_qty;
        $data->price = $request->price;
        $data->updated_by = Auth::user()->id;
        if ($data->save()) {
            $message ="<div class='alert alert-success'><a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a><b>Data Updated Successfully.</b></div>";
            return response()->json(['status'=> 300,'message'=>$message]);
        }
        else{
            return response()->json(['status'=> 303,'message'=>'Server Error!!']);
        } 
    }

    public function delete($id)
    {

        if(Product::destroy($id)){
            return response()->json(['success'=>true,'message'=>'Data has been deleted successfully']);
        }else{
            return response()->json(['success'=>false,'message'=>'Delete Failed']);
        }
    }

    public function assignProduct($id)
    {
        $data = Product::where('id',$id)->first();
        $additionalproducts = AdditionalItemTitle::with('additionalitem')->get();
        // dd($additionalproducts);
        return view('admin.product.assignproduct', compact('data','additionalproducts'));
    }

    public function assignProductStore(Request $request)
    {
        
        $product = $request->product_id;
        $items = $request->itemid;

        foreach ($items as $key => $item) {
            
            $additionalItem = AdditionalItem::where('id', $item)->first();
            
            $data = new AssignProduct();
            $data->product_id = $product;
            $data->additional_item_id = $item;
            $data->product_name = $additionalItem->item_name;
            $data->price = $additionalItem->amount;
            $data->save();

        }

        $upproduct = Product::find($product);
        $upproduct->assign = "1";
        $upproduct->assignitem = json_encode($items);
        $upproduct->save();

        return redirect()->route('admin.product')->with('success', 'Product Assign Successfully');

    }

    public function assignProductEdit($id)
    {
        $data = Product::where('id',$id)->first();
        $additionalproducts = AdditionalItemTitle::with('additionalitem')->get();
        
        $assignitems=DB::table('assign_products')
             ->where('product_id',$id)->pluck('additional_item_id')->all();

        // dd($assignitems);
        return view('admin.product.assignproductedit', compact('data','additionalproducts','assignitems'));
    }
}
