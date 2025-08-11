<?php

namespace App\Services;

use App\Http\Requests\MerchantProductRequest;
use App\Repositories\MerchantProductRepository;

class MerchantProductService {
    private $merchanProductRepository;

    public function __construct(MerchantProductRepository $merchantProductRepository){
        $this->merchanProductRepository = $merchantProductRepository;
    }

    public function create(MerchantProductRequest $request) {
        return $this->merchanProductRepository->create($request->validated());
    }

   

}