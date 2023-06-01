<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReprintList extends Model
{

    protected $table = 'reprint_label';

    //!Public Data
    protected $fillable = [
        'id',
        'counter_number',
        'date_processed',
        'created_at',
        'updated_at'
    ];

    protected $hidden = ['id'];
}
