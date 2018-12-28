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


    public function getAllProducts()
    {

        return $this->product->products();
    }

    public function getProductById($id)
    {
        return $this->product->product($id);
    }

    public function delete($id)
    {
        return response()->json($this->product->product($id)->delete());
    }

    public function validateImageRequest($request)
    {
        return $this->validate($request, [
            'images.*.url' => 'required'
        ])['images'];
    }

    public function validateProductRequest($request)
    {
        return $this->validate($request, [
            'name' => 'required',
            'sku' => 'required',
            'price' => 'required',
            'qty' => 'required',
            'description' => 'required',
            'special_price' => 'nullable'
        ]);
    }

    public function create(Request $request)
    {
        $data['product'] = $this->validateProductRequest($request);
        $data['images'] = $this->validateImageRequest($request);
        return  $this->product->addNew($data);
    }

    public function update($id, Request $request)
    {
        $data = $this->validateProductRequest($request);
        return response()->json($this->product->product($id)->update($data));
    }
}
