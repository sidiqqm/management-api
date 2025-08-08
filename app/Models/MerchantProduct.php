<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MerchantProduct extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'warehouse_id', 'product_id', 'merchant_id', 'stock'
    ];

    public function warehouse() {
        return $this->belongsTo(Warehouse::class);
    }
    public function product() {
        return $this->belongsTo(Product::class);
    }
    public function merchant() {
        return $this->belongsTo(Merchant::class);
    }
}
