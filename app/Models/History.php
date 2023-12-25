<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use SoftDeletes;

    protected $table = 'history';

    protected $fillable = [
        'id_history_id',
        'description',
        'language_code'
    ];

    public $incrementing = true;

    public function historyId()
    {
        return $this->hasOne(HistoryId::class, 'id', 'id_history_id');
    }
}
