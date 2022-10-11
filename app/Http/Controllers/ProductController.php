<?php

namespace App\Http\Controllers;
use App\Models\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $product_data = Product::orderBy('id','desc')->paginate(5);
   
        return view('products.index',compact('product_data'));
    }

    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'name' => 'required|max:50',
            'email' => 'required|email',
            'contact' => 'required',
        ]);

        $create_product  =  Product::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name' => $request->name, 
                        'email' => $request->email,
                        'contact' => $request->contact,
                    ]);
    
        return response()->json(['success' => true]);
    }

    public function edit(Request $request)
    {   
        $product_edit = array('id' => $request->id);
        $product  = Product::where($product_edit)->first();
 
        return response()->json($product);
    }

    public function destroy(Request $request)
    {
        $product = Product::where('id',$request->id)->delete();
   
        return response()->json(['success' => true]);
    }
}
