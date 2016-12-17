<?php

/**
 *
 */
if ( ! function_exists( 'add_commentcode' ) ) {
    function add_commentcode( $sTag, $aoCallable ) {
        add_filter( 'commentcode_tag_' . $sTag, $aoCallable );
    }
}
if ( ! function_exists( 'do_commentcode' ) ) {
    function do_commentcode( $sContent ) {
        return apply_filters( 'commentcode_content', $sContent );
    }
}