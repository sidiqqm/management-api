<?php

namespace App\Services;

use App\Repositories\WarehouseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class WarehouseService {
    private $warehouseRepository;

    public function __construct(WarehouseRepository $warehouseRepository) {
        $this->warehouseRepository = $warehouseRepository;
    }

    public function getAll(array $fields) {
        return $this->warehouseRepository->getAll($fields);
    }

    public function getById(int $id, array $fields) {
        return $this->warehouseRepository->getById($id, $fields);
    }

    public function create(array $data) {
        if(isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->warehouseRepository->create($data);
    }

    public function update(int $id, array $data) {
        $fields = ['*'];
        $warehouse = $this->warehouseRepository->getById($id, $fields);
        
        if(isset($data['photo']) && $data['photo'] instanceof UploadedFile) {
            if(!empty($warehouse->photo)) {
                $this->deletePhoto($warehouse->photo);
            }
            $data['photo'] = $this->uploadPhoto($data['photo']);
        }

        return $this->warehouseRepository->update($id, $data);
    }

    public function delete(int $id) {
        $fields = ['id', 'photo'];
        $warehouse = $this->warehouseRepository->getById($id, $fields);

        if($warehouse->photo) {
            $this->deletePhoto($warehouse->photo);
        }

        $this->warehouseRepository->delete($id);
    }

    private function uploadPhoto(UploadedFile $photo) {
        return $photo->store('warehouses', 'public');
    }

    private function deletePhoto(string $photoPath) {
        if(Storage::disk('public')->exists('warehouses')){
            Storage::disk('public')->exists('warehouses');
        }
    }
}