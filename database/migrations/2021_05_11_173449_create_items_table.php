<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('item_no');
            $table->string('user_id');
            $table->string('itemimage_id')->nullable();
            $table->string('name');
            $table->string('desc')->nullable();
            $table->string('cat')->nullable();
            $table->string('brand')->nullable();
            $table->string('barcode')->nullable();
            $table->string('qty');
            // $table->string('cost_price')->nullable();
            $table->string('price')->nullable();
            $table->string('cost_price')->nullable();
            $table->string('profits')->default(0);
//             INSERT INTO `items` (`id`, `item_no`, `user_id`, `itemimage_id`, `name`, `desc`, `cat`, `brand`, `barcode`, `qty`, `price`, `cost_price`, `profits`, `img`, `thumb_img`, `bm`, `b1`, `b2`, `b3`, `b4`, `b5`, `b6`, `b7`, `qm`, `q1`, `q2`, `q3`, `q4`, `q5`, `q6`, `q7`, `publish`, `del`, `created_at`, `updated_at`) VALUES
// (1, 'MT281407', '1', '8', 'Cement, Dangote', 'Dangote Cement', 'Building', 'Dangote', '7654321', '29', '33', '30', NULL, 'item14-071.jpeg', 'item14-071.jpeg', NULL, '38', '35', '33', NULL, NULL, NULL, NULL, '0', '5', '13', '11', NULL, NULL, NULL, NULL, 'yes', 'no', '2021-06-28 12:14:07', '2021-07-30 10:04:48'),
// (2, 'MT284042', '1', '9', 'Hammer', 'Wooden Hammer', 'Carpentary', NULL, NULL, '18', '10', '10', NULL, 'no_image.png', 'no_image.png', '0', '15', '14', '12', NULL, NULL, NULL, NULL, '0', '3', '10', '5', NULL, NULL, NULL, NULL, 'yes', 'no', '2021-06-28 12:40:42', '2021-07-30 08:47:13'),
// (3, 'dfdds', 'gdfg', 'dfgdfg', 'fdgfg', 'fdgfg', '3t4gd', '3454', '3454', '45', '454', '345', '344', 'rtr', 'erter', '0', '449', '2', '9', NULL, NULL, NULL, NULL, '0', '41', '3', '1', NULL, NULL, NULL, NULL, 'yes', 'yes', NULL, '2021-08-05 15:18:35');
            $table->string('img')->nullable();
            $table->string('thumb_img')->nullable();
            $table->string('bm')->default(0);
            $table->string('b1')->default(0);
            $table->string('b2')->default(0);
            $table->string('b3')->default(0);
            $table->string('b4')->nullable();
            $table->string('b5')->nullable();
            $table->string('b6')->nullable();
            $table->string('b7')->nullable();
            $table->string('qm')->default(0);
            $table->string('q1')->default(0);
            $table->string('q2')->default(0);
            $table->string('q3')->default(0);
            $table->string('q4')->nullable();
            $table->string('q5')->nullable();
            $table->string('q6')->nullable();
            $table->string('q7')->nullable();
            $table->string('publish')->default('yes');
            $table->string('del')->default('no');
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
        Schema::dropIfExists('items');
    }
}
