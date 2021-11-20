<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
      'title','category','deposit','price'
    ];

    public function admin_fee(){
        return $this->hasOne(AdminFee::class,'product_id','id');
    }

    /* Auto Create Admin Fee */
    public function fee(){
        $title = str_replace(" ","-",strtolower($this->title));
        $fee = (int) $this->price - ( ((int) $this->price * 95) / 100); /* get 5% fee */
        $this->admin_fee()->create([
            'title' => $title,
            'fee' => $fee
        ]);
    }
}
