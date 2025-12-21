<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
            public function up()
        {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('order_id');
                $table->unsignedBigInteger('food_id');
                $table->integer('quantity');

                $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
                $table->foreign('food_id')->references('id')->on('foods')->onDelete('cascade');

                $table->timestamps();
            });
        }

        public function down()
        {
            Schema::dropIfExists('order_items');
        }

};
