<?php

namespace App\Model;

use App\Model\Product\Image;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'updated_at', 'updated_at'];

    protected $with = ['images'];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function products()
    {
        return $this->with($this->with)->paginate(env('PAGINATION_LIMIT', 100));
    }

    public function product($id)
    {
        return $this->with($this->with)->findOrFail($id);
    }


    public function getProductById($id)
    {
        return $this->with($this->with)->findOrFail($id);
    }

    public function addNew($data)
    {
        $product =  $this->create($data['product']);
        $product->images()->createMany($data['images']);
        return $product->fresh();
    }
}
