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
    protected $guarded = ['id'];

    protected $with = ['images'];

    protected $perPage = 100;

    public function images(){

        return $this->hasMany(Image::class);

    }

    public function products(){

        return $this->with($this->with)->all();

    }

    public function productsWithPaginate(){

        return $this->with($this->with)->paginate(env('PAGINATION_LIMIT', 100));

    }

    public function getProductById($id){

        return $this->with($this->with)->findOrFail($id);

    }

    public function getProductBySku($sku){

        return $this->with($this->with)->where('sku', $sku)->get();

    }

    public function create(){

    }
}
