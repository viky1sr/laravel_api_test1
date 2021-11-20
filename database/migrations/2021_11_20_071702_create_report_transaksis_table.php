<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportTransaksisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_transaksis', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });

        Schema::table('report_transaksis',function (Blueprint $table) {
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('admin_fee_id');
            $table->unsignedBigInteger('log_pembelian_id');

            $table->foreign('customer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('admin_fee_id')->references('id')->on('admin_fees')->onDelete('cascade');
            $table->foreign('log_pembelian_id')->references('id')->on('log_pembelian_customers')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_transaksis');
    }
}
