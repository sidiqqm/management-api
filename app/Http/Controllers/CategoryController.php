<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryResource;
use App\Services\CategoryService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $fields = ['id', 'name', 'photo', 'tagline'];

        $categories = $this->categoryService
            ->getAll($fields);

        return response()
            ->json(CategoryResource::collection($categories));
    }

    public function show(int $id)
    {
        $fields = ['id', 'name', 'photo', 'tagline'];

        $category = $this->categoryService
            ->getById($id, $fields);

        return response()
            ->json(new CategoryResource($category));
    }

    public function store(CategoryRequest $request)
    {
        $category = $this->categoryService
            ->create($request->validated());

        return response()
            ->json(new CategoryResource($category), 201);
    }

    public function update(CategoryRequest $request, int $id) {
        try {
            $category = $this->categoryService->update($id, $request->validated());

            return response()->json(new CategoryResource($category));
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }
    }

    public function delete(int $id) {
        try {
            $this->categoryService->delete($id);
        } catch(ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Category not found'
            ], 404);
        }
    }
}
