<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository
{

    public function getAll(array $fields)
    {
        return Category::select($fields)
            ->latest()
            ->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Category::select($fields)
            ->findOrFail($id);
    }

    public function create(array $fields) {
        return Category::create($fields);
    }

    public function update(int $id, array $data) {
        $category = Category::findOrFail($id);

        $category->update($data);

        return $category;
    }

    public function delete(int $id) {
        $category = Category::findOrFail($id);

        $category->delete();
    }

}