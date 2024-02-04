<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormContactUs extends Model
{
    use HasFactory;

    protected $table = 'form_contact_us';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $fillable  = [
        'name',
        'phone_number',
        'email',
        'city',
        'number_of_floors',
        'message',
    ];

    public $timestamps = true;
}
