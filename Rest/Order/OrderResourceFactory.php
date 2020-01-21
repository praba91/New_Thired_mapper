<?php
namespace Sales\V1\Rest\Order;

class OrderResourceFactory
{
    public function __invoke($services)
    {
    	$mapper=$services->get('Sales\V1\Rest\Order\OrderMapper');
        return new OrderResource($mapper);
    }
}
