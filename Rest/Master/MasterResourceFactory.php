<?php
namespace Sales\V1\Rest\Master;

class MasterResourceFactory  {
    public function __invoke($services) {
        $mapper=$services->get('Sales\V1\Rest\Master\MasterMapper');
        return new MasterResource($mapper);   
    } 
}
