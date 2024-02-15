<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductHighlight extends Model
{
    use SoftDeletes;

    protected $table = 'product_highlight';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_product_highlight_id',
        'name',
        'description',
        'language_code'
    ];

    public $timestamps = true;

    public function productHighlightId()
    {
        return $this->hasOne(ProductHighlightId::class, 'id', 'id_product_highlight_id');
    }
}
