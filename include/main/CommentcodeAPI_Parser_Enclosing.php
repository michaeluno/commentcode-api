<?php

/**
 * A enclosing comentcode parser.
 *
 * ```
 * <!--- my_commentcode color="#FFF" name="white" --->Some text.<!---/my_commentcode --->
 * ```
 *
 * @since   0.3.0
 */
class CommentcodeAPI_Parser_Enclosing extends CommentcodeAPI_Parser_Base {

     /**
     * @since       0.3.0
     * @return      string
     */
    protected function _getRegularExpressionPattern() {
        return '/'
                . "<!---[\s]*(?P<tag>[\w]+)[\s]*"
                . "\s+?(?P<attr>[^>]*?)[\s]*"
                . "--->"
                . "(?P<innerhtml>"
                    . "(?:"
                        . "(?:"
                            . '.(?!--->)'
                        . ")"
                        . "|"
                        . "(?R)"
                    . ")"
                    . "*"
                . ")"   // end match #3
                . "<!---[\s]*\/(?P=tag)[\s]*--->"
            . "/sm";
    }

    /**
     * @param       array   $aMatches
     * @since       0.1.0
     * @callback    function    preg_replace_callback
     * @return      string
     */
    protected function _replyToReplaceCommentcode( $aMatches ) {
        return apply_filters(
            'commentcode_tag_' . $aMatches[ 'tag' ],      // filter hook name
            $this->_getTextParsed( $aMatches[ 'innerhtml' ] ), // 1st parameter:  string to be filtered - parse nested items.
            $this->_getArguments( $aMatches[ 'attr' ] ),  // 2st parameter - attributes
            $aMatches[ 'tag' ]   // 3nd parameter - the commentcode tag
        );
    }

}