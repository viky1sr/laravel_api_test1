<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReportTransaksi extends Model
{
    use HasFactory;

    protected $fillable = [
      'customer_id','product_id','admin_fee_id','log_pembelian_id'
    ];
}
