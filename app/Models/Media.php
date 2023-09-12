<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'uuid', 'name', 'path', 'file_name', 'mime_type', 'disk', 'size', 'type', 'extension', 'content_type'
    ];

    protected $appends = ['directory'];

    public function mediable()
    {
        return $this->morphTo();
    }
}
