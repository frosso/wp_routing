<?php

class TemplateRedirectResource {

    public static function override_template( $template ) {
        if ( is_file( $template ) ) {
            add_filter( 'template_include', create_function( '$old_template', "return '$template';" ) );
        }
    }

    public static function load_template( $template, $query = false, $force_header = 0 ) {
        $template = locate_template( $template );

        if ( $force_header ) {
            add_filter( 'status_header', create_function( '$status_header,$header,$text,$protocol', "
                $text = get_status_header_desc( $force_header );
                return \"$protocol $force_header $text\";
            "), 10, 4 );
        }

        if ( $query ) {
            add_action( 'do_parse_request', create_function('', "
                global $wp;

                if ( is_callable( $query ) )
                    $query = call_user_func( $query );

                if ( is_array( $query ) )
                    $wp->query_vars = $query;
                elseif ( !empty( $query ) )
                    parse_str( $query, $wp->query_vars );
                else
                    return true;
                // Could not interpret query. Let WP try.

                return false;
            " ) );
        }
        if ( $template ) {
            add_action( 'wp_loaded', create_function('', "
                wp( );
                do_action( 'template_redirect' );
                load_template( $template );
                exit ;
            " ) );
        }
    }

}
