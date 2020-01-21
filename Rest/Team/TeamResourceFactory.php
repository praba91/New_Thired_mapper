<?php
namespace Sales\V1\Rest\Team;

class TeamResourceFactory
{
    public function __invoke($services) {
        $mapper=$services->get('Sales\V1\Rest\Team\TeamMapper');
        return new TeamResource($mapper);
    } 
}
