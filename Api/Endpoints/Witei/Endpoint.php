<?php

namespace Inmoob\Api\Endpoints\Witei;
use OBSER\Classes\Api\Endpoint AS ObserEndpoint;

abstract class Endpoint extends ObserEndpoint{
    protected static $namespace = 'inmoob/v1/witei';
    protected static $method    = 'POST';
}