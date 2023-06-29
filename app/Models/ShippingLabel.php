<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShippingLabel extends Model
{
   /**
    * ! The table associated with the model.
    *
    * @var string
    */
   protected $table = 'shipping_label';



   //!Public Data
   protected $fillable = [
      'id',

      'transfer_number',

      'po_trans_loc_code_from',
      'po_trans_loc_from_name',

      'po_trans_loc_code_to',
      'po_trans_loc_to_name',

      'po_trans_loc_to_route_desc',

      'po_number',

      'counter_number',
      'od_number',

      'sales_invoice_number',

      'total_box_count',

      'checked_by',

      'po_vendor_name',

      'printed_at',

      'created_at',
      'updated_at'
   ];

   //!Data hidden
   protected $hidden = [
      'updated_at'
   ];
}
