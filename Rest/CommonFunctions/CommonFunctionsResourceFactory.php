<?php
namespace Sales\V1\Rest\CommonFunctions;

class CommonFunctionsResourceFactory
{
    public function __invoke($services)
    {
      $mapper=$services->get('Sales\V1\Rest\CommonFunctions\CommonFunctionsMapper');
        return new CommonFunctionsResource($mapper); 
    }
}
