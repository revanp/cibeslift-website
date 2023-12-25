<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class HistoryId extends Model
{
    use SoftDeletes;

    protected $table = 'history_id';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'year',
        'is_active',
        'sort',
        'image'
    ];

    public $timestamps = true;

    public function history()
    {
        return $this->hasMany(History::class, 'id_history_id', 'id');
    }

    public function image()
    {
        return $this->morphOne('App\Models\Media', 'mediable')->where('content_type', 'image');
    }
}
