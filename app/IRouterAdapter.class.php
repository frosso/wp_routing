<?php

interface IRouterAdapter {
    public function map( $route, $target, $methods = 'GET', $name = null );

    public function match( $requestUrl = null, $requestMethod = null );

    public function setBasePath( $basePath );

    public function generate( $name, array $params = array() );
}
