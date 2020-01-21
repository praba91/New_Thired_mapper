<?php
namespace Sales\V1\Rest\Reports;

class ReportsResourceFactory
{
    public function __invoke($services)
    {
    	$mapper=$services->get('Sales\V1\Rest\Reports\ReportsMapper');
        return new ReportsResource($mapper);
    }
}
