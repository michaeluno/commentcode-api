<?php

/**
 * Sets up necessary hooks for commentcodes.
 * @since       0.1.0
 */
class CommentcodeAPI_Sample {

    /**
     * Performs necessary set-ups.
     */
    public function __construct() {
        add_commentcode( 'sample_commentcode', array( $this, 'replyToPrintArguments' ) );
    }

    /**
     * @param       string      $sText
     * @param       string      $aArguments
     * @callback    filter      commentcode_content
     * @return      string
     */
    public function replyToPrintArguments( $sText, $aArguments ) {
        return "<pre>"
                . htmlspecialchars( print_r( $aArguments, true ) )
            . "</pre>";
    }

}