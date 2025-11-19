<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alteration extends Model
{
    protected $table = 'alteration';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'type',
        'description',
        'attachment',
    ];
}
