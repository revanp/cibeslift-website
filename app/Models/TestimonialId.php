<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TestimonialId extends Model
{
    use SoftDeletes;

    protected $table = 'testimonial_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_id',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function testimonial()
    {
        return $this->hasMany(Testimonial::class, 'id_testimonial_id', 'id');
    }

    public function productId()
    {
        return $this->hasOne(ProductId::class, 'id', 'id_product_id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
