<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use SoftDeletes;

    protected $table = 'testimonial';

    protected $fillable = [
        'id_testimonial_id',
        'customer',
        'testimony',
        'language_code'
    ];

    public $incrementing = true;

    public function testimonialId()
    {
        return $this->hasOne(TestimonialId::class, 'id', 'id_testimonial_id');
    }
}
