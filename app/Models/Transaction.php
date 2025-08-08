<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    /** @use HasFactory<\Database\Factories\TransactionFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'phone',
        'tax_total',
        'sub_total',
        'grand_total',
        'merchant_id'
    ];

    public function merchant() {
        return $this->belongsTo(Merchant::class);
    }

    public function transactionProducts() {
        return $this->hasMany(TransactionProduct::class);
    }
}
