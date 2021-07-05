<?php

namespace Inmoob\Api\Endpoints\Properties;
use OBSER\Classes\Api\Endpoint AS ObserEndpoint;

abstract class Endpoint extends ObserEndpoint{
    protected static $namespace = 'inmoob/v1/properties';
    protected static $method    = 'POST';
}