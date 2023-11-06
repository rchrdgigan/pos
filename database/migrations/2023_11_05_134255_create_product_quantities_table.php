<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('product_quantities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('sale_item_id')->nullable();
            $table->unsignedBigInteger('delivery_item_id')->nullable();
            $table->integer('quantity')->default(0);
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('sale_item_id')->references('id')->on('transaction_sale_items')->onDelete('cascade');
            $table->foreign('delivery_item_id')->references('id')->on('delivery_items')->onDelete('cascade');
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
        Schema::dropIfExists('product_quantities');
    }
};
