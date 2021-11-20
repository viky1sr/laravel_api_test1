<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLogPembelianCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_pembelian_customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('total_price')->default(0);
            $table->string('deposit_before')->nullable();
            $table->string('deposit_after')->nullable();
            $table->timestamps();
        });

        Schema::table('log_pembelian_customers',function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('admin_fee_id');

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('admin_fee_id')->references('id')->on('admin_fees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_pembelian_customers');
    }
}
