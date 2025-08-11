<?php

namespace App\Repositories;

use App\Models\MerchantProduct;
use Illuminate\Validation\ValidationException;

class MerchantProductRepository {
    public function create(array $data) {
        return MerchantProduct::create($data);
    }

    public function getMerchantAndProduct(int $merhcantId, int $productId) {
        return MerchantProduct::where('merchant_id', $merhcantId)
        ->where('product_id', $productId)
        ->first();
    }

    public function update(int $merhcantId, int $productId, int $stock) {
        $merchanProduct = $this->getMerchantAndProduct($merhcantId, $productId);
        if(!$merchanProduct) {
            throw ValidationException::withMessages([
                'message' => 'Product not found'
            ]);
        }

        return $merchanProduct->update([
            ['stock' => $stock]
        ]);
    }
}