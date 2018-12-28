<?php

namespace App\Http\Controllers;

use App\Model\Product;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ProductController extends Controller
{
    /**
     * Dddd
     *
     * @var Product
     */
    protected $product;


    /**
     * ProductController constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function getAllProducts()
    {

        return $this->product->products();
    }


    /**
     * @param $id
     * @return Product|Product[]|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model
     */
    public function getProductById($id)
    {
        return $this->product->product($id);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request)
    {

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

    /**
     * @param $id
     * @param Request $request
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function update($id, Request $request)
    {
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return response('Update Successfully');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function delete($id)
    {
        Product::findOrFail($id)->delete();
        return response('Deleted Successfully');
    }
}
