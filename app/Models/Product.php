<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'thumbnail',
        'about',
        'price',
        'category_id',
        'is_popular',
    ];

    public function category() {
        return $this->BelongsTo(Category::class);
    }

    public function warehouses() {
        return $this->belongsToMany(Warehouse::class, 'warehouse_products')
        ->withPivot('stock')
        ->withTimestamps();
    }

    public function merchants() {
        return $this->belongsToMany(Merchant::class, 'merchant_products')
        ->withPivot('stock')
        ->withTimestamps();
    }

    public function transactions() {
        return $this->hasMany(TransactionProduct::class);
    }

    public function getWarehouseProductStock() {
        return $this->warehouse()->sum('stock');
    }
    
    public function getMerchantProductStock() {
        return $this->merchant()->sum('stock');
    }

    public function getThumbnailAttribute($value) {
        if(!$value){
            return null;
        }

        return url(Storage::url($value));
    }
    
}
