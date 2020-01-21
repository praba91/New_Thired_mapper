<?php
namespace Sales\V1\Rest\Product;

class ProductResourceFactory
{
    public function __invoke($services) {
        $mapper=$services->get('Sales\V1\Rest\Product\ProductMapper');
        return new ProductResource($mapper); 
    }
}
