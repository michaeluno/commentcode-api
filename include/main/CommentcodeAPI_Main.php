<?php

/**
 * Sets up necessary hooks for commentcodes.
 * @since       0.1.0
 */
class CommentcodeAPI_Main {

    /**
     * Performs necessary set-ups.
     */
     public function __construct() {
         add_filter( 'the_content', 'do_commentcode', 12 );
         add_filter( 'commentcode_content', array( $this, 'replyToDoCommentcode' ) );
     }

    /**
     * @param       string      $sContent
     * @callback    filter      commentcode_content
     * @return      string
     */
     public function replyToDoCommentcode( $sContent ) {
         $_oParser = new CommentcodeAPI_Parser_Enclosing( $sContent );
         $sContent = $_oParser->get();
         $_oParser = new CommentcodeAPI_Parser_SelfClosing( $sContent );
         return $_oParser->get();
     }

}