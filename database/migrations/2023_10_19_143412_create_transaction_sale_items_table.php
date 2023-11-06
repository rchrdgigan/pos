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
        Schema::create('transaction_sale_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_sale_id');
            $table->unsignedBigInteger('product_id');
            $table->string('sal_discount');
            $table->string('sal_price');
            $table->string('sal_subtotal');
            $table->string('sal_totalprice');
            $table->foreign('transaction_sale_id')->references('id')->on('transaction_sales')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_sale_items');
    }
};
