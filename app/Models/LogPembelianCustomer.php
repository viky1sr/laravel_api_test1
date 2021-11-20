<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LogPembelianCustomer extends Model
{
    use HasFactory;

    protected $table = 'log_pembelian_customers';

    protected $fillable = [
        'total_price', 'customer_id','product_id','admin_fee_id','deposit_before','deposit_after'
    ];

    public function product() {
        return $this->hasOne(Product::class, 'id', 'product_id');
    }

    public function admin_fee() {
        return $this->hasOne(AdminFee::class,'id','admin_fee_id');
    }

    public function customer() {
        return $this->hasOne(User::class,'id','customer_id');
    }

    public function report_transaksi() {
        return $this->hasOne(ReportTransaksi::class,'log_pembelian_id','id');
    }

    public function report() {
        $this->report_transaksi()->create([
            'customer_id' => $this->customer_id,
            'product_id' => $this->product_id,
            'admin_fee_id' => $this->admin_fee_id,
        ]);
    }
}
