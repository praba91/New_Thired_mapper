<?php
namespace Sales\V1\Rest\Customer;

class CustomerResourceFactory
{
    public function __invoke($services) {
        $mapper=$services->get('Sales\V1\Rest\Customer\CustomerMapper');
        return new CustomerResource($mapper);
    }
}
