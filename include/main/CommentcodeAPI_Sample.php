<?php

/**
 * Sets up necessary hooks for commentcodes.
 * @since       0.1.0
 */
class CommentcodeAPI_Sample {

    /**
     * Performs necessary set-ups.
     */
    public function __construct( $sCommentcodeTag ) {
        add_commentcode( $sCommentcodeTag, array( $this, 'replyToPrintDebugInformation' ) );
    }

    /**
     * @param       string      $sText          The enclosed HTML text.
     * @param       string      $aArguments     The parsed commentcode attributes.
     * @param       string      $sTag           The commentcode tag name.
     * @callback    filter      commentcode_tag_{commentcode tag name}
     * @return      string
     */
    public function replyToPrintDebugInformation( $sText, $aArguments, $sTag ) {

        return "<pre>"
                . "<h4>" . __( 'Commentcode', 'commentcode-api' ) . "</h4>"
                . "<p>"
                    . "<strong>" . __( 'Commentcode Tag', 'commentcode-api' ) . ": </strong>"
                    . "<span>" . $sTag . "</span>"
                . "</p>"
                . "<strong>" . __( 'Commentcode Arguments', 'commentcode-api' ) . ": </strong>"
                . "<code>" . htmlspecialchars( print_r( $aArguments, true ) ) . "</code>"
                . ( $sText
                    ? "<strong>" . __( 'Commentcode Text', 'commentcode-api' ) . "</strong>"
                        . "<div>" . $sText . "</div>"
                    : ''
               )
            . "</pre>";
    }

}