<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class NavbarMenu extends Model
{
    use SoftDeletes;

    protected $table = 'navbar_menu';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'id_page_id',
        'sort',
        'is_active',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    public $timestamps = true;

    public function pageId()
    {
        return $this->hasOne(PageId::class, 'id', 'id_page_id');
    }
}
