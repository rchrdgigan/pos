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
        Schema::create('transaction_sales', function (Blueprint $table) {
            $table->id();
            $table->string('trans_no')->unique();
            $table->unsignedBigInteger('user_id');
            $table->decimal('total_price', 8, 2)->default(0.00);
            $table->decimal('cash', 8, 2)->default(0.00);
            $table->decimal('change', 8, 2)->default(0.00);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
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
        Schema::dropIfExists('transaction_sales');
    }
};
