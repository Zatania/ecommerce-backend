<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('cart_items', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('CartID');
            $table->unsignedBigInteger('ProductID');
            $table->integer('quantity');
            $table->timestamps();

            $table->foreign('CartID')
                ->references('CartID')
                ->on('carts')
                ->onDelete('cascade');

            $table->foreign('ProductID')
                ->references('ProductID')
                ->on('products')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('cart_items');
    }
};
