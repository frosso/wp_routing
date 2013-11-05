<?php

class AltoRouterAdapter implements IRouterAdapter {

    protected $adaptee = null;
    public function __construct( ) {
        require_once ('AltoRouter/AltoRouter.php');
        $this->adaptee = new AltoRouter( );
    }

    public function map( $route, $target, $methods = 'GET|POST', $name = null ) {
        if ( is_array( $methods ) ) {
            $methods = implode( '|', $methods );
        }

        return $this->adaptee->map( $methods, $route, $target, $name );
    }

    public function match( $requestUrl = null, $requestMethod = null ) {
        return $this->adaptee->match( $requestUrl, $requestMethod );
    }

    public function setBasePath( $basePath ) {
        return $this->adaptee->setBasePath( $basePath );
    }

    public function generate( $name, array $params = array() ) {
        return $this->adaptee->generate( $name, $params );
    }

}
