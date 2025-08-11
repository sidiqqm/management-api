<?php

namespace App\Http\Controllers;

use App\Http\Requests\MerchantRequest;
use App\Http\Resources\MerchantResource;
use App\Services\MerchantService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    private $merchantService;

    public function __construct(MerchantService $merchantService)
    {
        $this->merchantService = $merchantService;
    }

    public function index()
    {
        $fields = ['name', 'photo', 'address', 'phone'];
        $merchant = $this->merchantService->index($fields);

        return response()->json(MerchantResource::collection($merchant));
    }

    public function getById(int $id)
    {
        try {
            $fields = ['*'];
            $merchant = $this->merchantService->getById($id, $fields);

            return response()->json(new MerchantResource($merchant));
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Merchant not found'
            ], 404);
        }
    }

    public function store(MerchantRequest $request) {
        $merchant = $this->merchantService->create($request->validated());
        return new JsonResource($merchant);
    }

    public function update(MerchantRequest $request, int $id) {
        try {
            $merchant = $this->merchantService->getById($id, $request->validated());
            return new JsonResource($merchant);
        }
    }

    public function destroy(int $id) {
        try {
            $this->merchantService->delete($id);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Merchant not found'
            ], 404);
        }
    }

    public function getMerchantProfile() {
        $userId = Auth::id();

        try {
            $merchant = $this->merchantService->getByKeeperId($userId);
            return new JsonResource($merchant);
        } catch (ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Merchant not found'
            ], 404);
        }
    }
}
