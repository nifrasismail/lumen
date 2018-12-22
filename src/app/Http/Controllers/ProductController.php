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
        return response()->json(Product::paginate(env('PAGINATION_LIMIT', 100)));
    }

    public function getAllProductsName(){
        return response()->json(Product::all()->map->name);
    }

    public function getProductById($id){
        return response()->json(Product::findOrFail($id));
    }
}
