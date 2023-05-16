<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PrintLabel extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('print_label', function (Blueprint $table) {
            $table->id();
            $table->string('transfer_number', 20);
            $table->string('converted_to_png', 60)->nullable();
            $table->string('printed_raw_data', 120)->nullable();
            $table->bigInteger('box_number');
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
        //
    }
}
