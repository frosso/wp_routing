<?php

class PHPRouterAdapter implements IRouterAdapter {
    protected $adaptee = null;
    public function __construct( ) {
        require_once ('PHP-Router/Router.php');
        require_once ('PHP-Router/Route.php');
        $this->adaptee = new Router( );
    }

    public function setBasePath( $basePath ) {
        return $this->adaptee->setBasePath( $basePath );
    }

    public function match( $requestUrl = null, $requestMethod = null ) {
        $route_info = false;
        $route = $this->adaptee->matchCurrentRequest( );

        if ( $route instanceof Route ) {
            $callback = $route->getTarget( );
            $params = $route->getParameters( );
            $name = $route->getName( );

            $route_info = array( );
            $route_info['target'] = $callback;
            $route_info['params'] = $params;
            $route_info['name'] = $name;
        }
        return $route_info;
    }

    public function map( $route, $target, $methods = 'GET,POST', $name = null ) {
        $args = array( );
        if ( is_string( $methods ) ) {
            $methods = explode( '|', $methods );
        }
        $methods = implode( ',', $methods );
        $args['methods'] = $methods;

        if ( $name != null && is_string( $name ) ) {
            $args['name'] = $name;
        }

        return $this->adaptee->map( $route, $target, $args );

    }

    public function generate( $name, array $params = array() ) {
        return $this->adaptee->generate( $name, $params );
    }

}
