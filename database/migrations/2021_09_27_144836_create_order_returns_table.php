<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderReturnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_returns', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('user_id');
            $table->string('sale_id');
            $table->string('item_id');
            $table->string('user_bv');
            $table->string('item_no');
            $table->string('name');
            $table->string('qty');
            $table->string('cost_price');
            $table->string('unit_price');
            $table->string('profits');
            $table->string('tot');
            $table->string('del_status');
            $table->string('del')->default('no');
            $table->string('order_date');
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
        Schema::dropIfExists('order_returns');
    }
}
