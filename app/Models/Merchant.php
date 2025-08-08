<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class Merchant extends Model
{
    /** @use HasFactory<\Database\Factories\MerchantFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'photo',
        'address',
        'phone',
        'keeper_id'
    ];

    public function keeper()
    {
        return $this->belongsTo(User::class, 'keeper_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'merchant_products')
            ->withPivot('stock')
            ->withPivot('warehouse_id')
            ->withTimestamps();
    }

    public function transaction() {
        return $this->hasMany(Transaction::class);
    }

    public function getPhotoAttribute($value)
    {
        if (!$value) {
            return null;
        }

        return url(Storage::url($value));
    }
}
