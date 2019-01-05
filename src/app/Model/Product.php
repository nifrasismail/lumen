<?php

namespace App\Model;

use App\Model\Product\Image;
use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use UsesUuid;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['uuid', 'updated_at', 'updated_at'];

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
