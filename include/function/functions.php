<?php

if ( ! function_exists( 'add_commentcode' ) ) {
    /**
     * @since   0.1.0
     * @param   string      $sTag           The commentcode tag.
     * @param   callable    $aoCallable     A callback function which gets called when the commentcode is processed.
     */
    function add_commentcode( $sTag, $aosCallable ) {
        add_filter( 'commentcode_tag_' . $sTag, $aosCallable, 10, 2 );
    }
}
if ( ! function_exists( 'do_commentcode' ) ) {
    /**
     * @param  string   $sContent
     * @return string
     */
    function do_commentcode( $sContent ) {
        return apply_filters( 'commentcode_content', $sContent );
    }
}