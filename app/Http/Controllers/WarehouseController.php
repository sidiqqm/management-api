<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Requests\WarehouseRequest;
use App\Http\Resources\WarehouseResource;
use App\Services\WarehouseService;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class WarehouseController extends Controller
{
    private $warehouseService;

    public function __construct(WarehouseService $warehouseService)
    {
        $this->warehouseService = $warehouseService;
    }

    public function index()
    {
        $fields = ['id', 'name', 'photo'];
        $warehouse = $this->warehouseService->getAll($fields);

        return response()->json(WarehouseResource::collection($warehouse));
    }

    public function show(int $id)
    {
        try {
            $fields = ['id', 'name', 'photo', 'phone'];
            $warehouse = $this->warehouseService->getById($id, $fields);

            return response()->json(new WarehouseResource($warehouse));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Warehouse not found'
            ], 404);
        }
    }

    public function store(WarehouseRequest $request)
    {
        $warehouse = $this->warehouseService->create($request->validated());

        return response()->json(new WarehouseResource($warehouse), 201);

    }

    public function update(WarehouseRequest $request, int $id)
    {
        try {
            $warehouse = $this->warehouseService->update($id, $request->validated());
            return response()->json(new WarehouseResource($warehouse));
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Warehouse not found'
            ], 404);
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->warehouseService->delete($id);
            return response(201);
        } catch(ModelNotFoundException $e) {
            return response(401);
        }
    }
}