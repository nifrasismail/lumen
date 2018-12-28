<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Model\Product;
use App\Model\Product\Image;
use Illuminate\Http\Request;

/**
 * Class ProductController
 * @package App\Http\Controllers
 */
class ImageController extends Controller
{
    /**
     *
     * @var Product
     */
    protected $product;

    protected $image;


    /**
     * ProductController constructor.
     *
     * @param Product $product
     */
    public function __construct(Product $product, Image $image)
    {
        $this->product = $product;
        $this->image = $image;
    }


    public function getImages($product_id)
    {
        return $this->product->product($product_id)->images;
    }

    public function getImage($product_id, $image_id)
    {
        return $this->product->product($product_id)->images()->findOrFail($image_id);
    }

    public function delete($product_id, Request $request)
    {
        $ids = $this->validateDeleteRequest($request);
        return response()->json(
            $this->product->product($product_id)->images()->whereIn('id', $ids)->delete()
        );
    }

    public function create($product_id, Request $request)
    {
        $data = $this->validateCreateRequest($request);
        return  $this->product->product($product_id)->images()->createMany($data);
    }

    public function update($product_id, Request $request)
    {
        $data = $this->validateUpdateRequest($request);
        $product = $this->product->product($product_id);
        foreach ($data as $k => $item) {
            $data[$k]['update'] = $product->images()->where('id', $item['id'])->update($item);
        }
        return $data;
    }

    public function validateDeleteRequest($request)
    {
        return $this->validate($request, [
            'images.*.id' => 'required'
        ])['images'];
    }

    public function validateUpdateRequest($request)
    {
        return $this->validate($request, [
            'images.*.id' => 'required',
            'images.*.url' => 'required'
        ])['images'];
    }

    public function validateCreateRequest($request)
    {
        return $this->validate($request, [
            'images.*.url' => 'required'
        ])['images'];
    }
}
