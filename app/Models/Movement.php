<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['type', 'quantity', 'product_id', 'supplier', 'reason', 'date'];

    public function product(){
        return $this->belongsTo(Product::class);
    }
}
