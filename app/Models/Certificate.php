<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'name',
        'national_id',
        'from_date',
        'to_date',
        'hours',
    ];
}
