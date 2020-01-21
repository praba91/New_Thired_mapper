<?php
namespace Sales\V1\Rest\Warehouse;

class WarehouseResourceFactory
{
    public function __invoke($services)
    {
    	$mapper=$services->get('Sales\V1\Rest\Warehouse\WarehouseMapper');
        return new WarehouseResource($mapper); 
    }
}
