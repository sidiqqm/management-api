<?php

namespace App\Repositories;

use App\Models\Warehouse;

class WarehouseRepository
{
    public function getAll(array $fields)
    {
        return Warehouse::select($fields)
            ->with(['products.category'])
            ->latest()
            ->paginate(10);
    }

    public function getById(int $id, array $fields)
    {
        return Warehouse::select($fields)
            ->with(['products.category'])
            ->findOrFail($id);
    }

    public function create(array $data) {
        return Warehouse::create($data);
    }

    public function update(int $id, array $data) {
        $warehouse = Warehouse::findOrFail($id);

        return $warehouse->update($data);
    }

    public function delete(int $id) {
        $warehouse = Warehouse::findOrFail($id);

        $warehouse->delete();
    }
}