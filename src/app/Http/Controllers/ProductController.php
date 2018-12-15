<?php

namespace App\Http\Controllers;

use App\Product;

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
        return response()->json(Product::paginate(100));
    }

    public function getProductById($id){
        return response()->json(Product::findOrFail($id));
    }
}
