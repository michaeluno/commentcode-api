<?php

if ( ! function_exists( 'add_commentcode' ) ) {
    /**
     * @since   0.1.0
     * @param   string      $sTag           The commentcode tag.
     * @param   callable    $aosCallable    A callback function which gets called when the commentcode is processed.
     */
    function add_commentcode( $sTag, $aosCallable ) {
         add_filter( 'commentcode_tag_' . $sTag, $aosCallable, 10, 3 );
    }
}
if ( ! function_exists( 'do_commentcode' ) ) {
    /**
     * @since   0.1.0
     * @param   string   $sContent
     * @return  string
     */
    function do_commentcode( $sContent ) {
        return apply_filters( 'commentcode_content', $sContent );
    }
}
if ( ! function_exists( 'has_commentcode' ) ) {
    /**
     * @since       0.3.0
     * @return      boolean
     */
    function has_commentcode( $sContent, $sTag ) {
        $_oParser = new CommentcodeAPI_Parser_Enclosing( $sContent );
        if ( $_oParser->hasCommentcode( $sTag ) ) {
            return true;
        }
        $_oParser = new CommentcodeAPI_Parser_SelfClosing( $sContent );
        return $_oParser->hasCommentcode( $sTag );
    }

}