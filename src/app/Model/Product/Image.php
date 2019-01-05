<?php

namespace App\Model\Product;

use App\Traits\UsesUuid;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
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
        return $this->with($this->with)->paginate(env('PAGINATION_LIMIT', 100));
    }
}
