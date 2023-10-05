<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductCategoryId extends Model
{
    use SoftDeletes;

    protected $table = 'product_category_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'sort',
        'video_url',
        'is_active',
        'is_self_design',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function productCategory()
    {
        return $this->hasMany(ProductCategory::class, 'id_product_category_id', 'id');
    }

    public function image()
    {
        return $this->morphMany('App\Models\Media', 'mediable')->where('content_type', 'image');
    }

    public function thumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'thumbnail');
    }

    public function banner()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'banner');
    }

    public function fileIcon()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'file_icon');
    }

    public function videoThumbnail()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'video_thumbnail');
    }
}
