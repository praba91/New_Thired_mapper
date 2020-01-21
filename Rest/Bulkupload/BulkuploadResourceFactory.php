<?php
namespace Sales\V1\Rest\Bulkupload;

class BulkuploadResourceFactory
{
    public function __invoke($services)
    {
       $mapper=$services->get('Sales\V1\Rest\Bulkupload\BulkuploadMapper');
        return new BulkuploadResource($mapper); 
    }
}
