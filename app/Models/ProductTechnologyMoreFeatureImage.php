<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTechnologyMoreFeatureImage extends Model
{
    protected $table = 'product_technology_more_feature_image';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [

    ];

    public $timestamps = true;

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
