<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminFee extends Model
{
    use HasFactory;

    protected $fillable = [
      'title','fee','product_id'
    ];
}
