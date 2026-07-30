<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movement extends Model
{
    protected $fillable = ['type', 'quantity', 'product_id', 'supplier', 'reason', 'date'];

    protected function casts(): array
    {
        return [
            'date' => 'date',
        ];
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
