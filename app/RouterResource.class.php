<?php

class RouterResource {

    protected static $router = null;

    protected static $instance = null;
    public static function get_instance( ) {
        if ( self::$instance == null ) {
            self::$instance = new RouterResource( );
        }
        return self::$instance;
    }

    private function __construct( ) {
    }

    public static function add_route( $route, $callback, $name = null, $methods = 'GET|POST' ) {
        self::get_router( )->map( $route, $callback, $methods, $name );
    }

    public static function init_routes( ) {

        $route_info = self::get_router( )->match( );
        if ( $route_info !== false ) {
            self::$route_info = $route_info;
            $callback = $route_info['target'];
            $params = $route_info['params'];
            // TODO: modifica per rendere compatibile con controller/view
            if ( is_callable( $callback ) ) {
                $callback( $params );
            } else {
                return self::$route_info;
            }
        }
    }

    public static function get_router( ) {
        if ( self::$router == null ) {
            self::$router = new AltoRouterAdapter( );
            self::$router->setBasePath( '/' );
        }
        return self::$router;
    }

    protected static $route_info = null;
    public static function get_route_info( ) {
        return self::$route_info;
    }

    public static function generate( $name, array $params = array() ) {
        return self::get_router( )->generate( $name, $params );
    }

}
