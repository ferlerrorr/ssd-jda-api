<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingLabelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_label', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number',20);
            $table->bigInteger('po_trans_loc_code_from');
            $table->string('po_trans_loc_from_name',20);
            $table->bigInteger('po_trans_loc_code_to');
            $table->string('po_trans_loc_to_name',100);
            $table->string('po_trans_loc_to_route_desc',100);
            $table->bigInteger('po_number');
            $table->bigInteger('counter_number');
            $table->bigInteger('od_number');
            $table->string('sales_invoice_number',50);
            $table->bigInteger('total_box_count');
            $table->string('checked_by',10);
            $table->string('po_vendor_name',100);
            $table->dateTime('printed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shipping_label');
    }
}
