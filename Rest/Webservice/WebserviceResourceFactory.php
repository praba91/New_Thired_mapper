<?php
namespace Sales\V1\Rest\Webservice;

class WebserviceResourceFactory
{
    public function __invoke($services) {
        $mapper=$services->get('Sales\V1\Rest\Webservice\WebserviceMapper');
        return new WebserviceResource($mapper);
    } 
}
