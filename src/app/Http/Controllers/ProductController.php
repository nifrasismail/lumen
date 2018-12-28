<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function getAllProducts(){
        return response()->json(Product::paginate(env('PAGINATION_LIMIT', 100)));
    }

    /*
     * @todo route model binding
     * */
    public function getProductById($id){
        return response()->json(Product::with(['images'])->findOrFail($id));
    }

    public function create(Request $request){

        $product  = new Product(
            $this->validate($request, [
                'name' => 'required',
                'sku' => 'required',
                'price' => 'required',
                'description' => 'required',
                'special_price' => 'required'
            ])
        );
        $product->save();
        return response('Created Successfully');
    }

    public function update($id, Request $request){
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response('Update Successfully');
    }

    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully');
    }
}
