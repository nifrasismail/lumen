<?php

namespace App\Model\Product;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'updated_at', 'updated_at'];

    public function images()
    {
        return $this->with($this->with)->paginate(env('PAGINATION_LIMIT', 100));
    }
}
