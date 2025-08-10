<?php

namespace App\Http\Controllers;

use App\Http\Requests\WarehouseProductRequest;
use App\Services\WarehouseService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WarehouseProductController extends Controller
{
    private $warehouseService;
    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function attach(WarehouseProductRequest $request, int $warehouseId)
    {
        $validated = $request->validated();

        $this->warehouseService->attachProduct(
            $warehouseId,
            $validated['product_id'],
            $validated['stock']
        );
        return response(201);
    }

    public function detach(int $warehouseId, int $productId)
    {
        $this->warehouseService->detachProduct($warehouseId, $productId);

        return response(201);
    }


    public function update(WarehouseProductRequest $request, int $warehouseId, int $productId)
    {
        $warehouseProduct = $this->warehouseService->updateProductStock(
            $warehouseId,
            $productId,
            $request->validated()['stock']
        );

        return new JsonResource($warehouseProduct);
    }
}
