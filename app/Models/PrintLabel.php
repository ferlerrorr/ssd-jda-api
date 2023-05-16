<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrintLabel extends Model
{
    // use HasFactory;




    protected $table = 'print_label';



    //!Public Data
    protected $fillable = [
        'id',
        'transfer_number',
        'converted_to_png',
        'printed_raw_data',
        'box_number',
        'created_at',
        'updated_at'
    ];
}
